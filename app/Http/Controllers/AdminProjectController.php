<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use League\Flysystem\UnableToDeleteFile;
use Throwable;

class AdminProjectController extends Controller
{
    public function index()
    {
        return renderSection('projectsAdmin', __('portfolio.projects'), null, 200, 'noindex,nofollow', [
            'projects' => Project::orderBy('position')->orderBy('id')->paginate(12)->withQueryString(),
        ]);
    }

    public function create()
    {
        return $this->form(new Project(['position' => (int) Project::max('position') + 1, 'is_featured' => true]));
    }

    public function edit(Project $project)
    {
        return $this->form($project);
    }

    private function form(Project $project)
    {
        return renderSection('projectEditor', __('portfolio.projects'), null, 200, 'noindex,nofollow', compact('project'));
    }

    public function store(SaveProjectRequest $request)
    {
        return $this->save($request, new Project);
    }

    public function update(SaveProjectRequest $request, Project $project)
    {
        return $this->save($request, $project);
    }

    private function save(SaveProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        $newPaths = $removedPaths = [];
        try {
            DB::transaction(function () use ($request, $data, &$project, &$newPaths, &$removedPaths): void {
                if ($project->exists) {
                    $project = Project::whereKey($project->id)->lockForUpdate()->firstOrFail();
                }
                $media = [];
                $coverIndex = 0;
                $selectedCover = $data['cover_index'] ?? $project->cover_index ?? 0;
                foreach ($project->media ?? [] as $index => $image) {
                    if (in_array($index, $data['remove_media'] ?? [])) {
                        if ($image['disk'] === 'blog') {
                            $removedPaths[] = $image['path'];
                        }
                    } else {
                        if ((string) $selectedCover === (string) $index) {
                            $coverIndex = count($media);
                        }
                        $image['alt'] = $data['media_alt'][$index] ?? $image['alt'] ?? [];
                        $media[] = $image;
                    }
                }
                if (count($media) + count($request->file('uploads', [])) > 20) {
                    throw ValidationException::withMessages(['uploads' => __('portfolio.image_limit')]);
                }
                foreach ($request->file('uploads', []) as $upload) {
                    if ($selectedCover === 'new' && empty($newPaths)) {
                        $coverIndex = count($media);
                    }
                    $path = $upload->store('projects', 'blog');
                    $newPaths[] = $path;
                    $media[] = ['path' => $path, 'disk' => 'blog', 'alt' => []];
                }
                $published = $data['status'] === 'published';
                $project->fill(collect($data)->only([
                    'slug', 'translations', 'position', 'technologies', 'repository_url', 'website_url',
                ])->all());
                $project->fill([
                    'media' => $media, 'cover_index' => $coverIndex, 'is_featured' => $request->boolean('is_featured'),
                    'is_published' => $published,
                    'published_at' => $published ? ($project->published_at ?? now()) : null,
                ])->save();
            });
        } catch (Throwable $exception) {
            $this->deleteFiles($newPaths);
            throw $exception;
        }
        $cleaned = $this->deleteFiles($removedPaths);

        return redirect()->route('admin.projects.edit', ['project' => $project, 'lang' => app()->getLocale()])
            ->with('status', __('portfolio.saved'))->with('warning', $cleaned ? null : __('blog.cleanup_warning'));
    }

    public function destroy(Request $request, Project $project)
    {
        $request->validate(['confirm_delete' => ['accepted']]);
        $paths = collect($project->media)->where('disk', 'blog')->pluck('path')->all();
        $project->delete();
        $cleaned = $this->deleteFiles($paths);

        return redirect()->route('admin.projects.index', ['lang' => app()->getLocale()])
            ->with('status', __('portfolio.deleted'))->with('warning', $cleaned ? null : __('blog.cleanup_warning'));
    }

    private function deleteFiles(array $paths): bool
    {
        try {
            return empty($paths) || Storage::disk('blog')->delete($paths);
        } catch (UnableToDeleteFile $exception) {
            report($exception);

            return false;
        }
    }
}
