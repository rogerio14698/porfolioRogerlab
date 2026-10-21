<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveBlogRequest;
use App\Models\Blog;
use App\Services\UploadImageOptimizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use League\Flysystem\UnableToDeleteFile;
use Throwable;

class AdminBlogController extends Controller
{
    public function index()
    {
        return renderSection('blogAdmin', __('blog.dashboard'), null, 200, 'noindex,nofollow', [
            'articles' => Blog::with('images')->latest()->paginate(12)->withQueryString(),
        ]);
    }

    public function create()
    {
        return $this->form(new Blog);
    }

    public function edit(Blog $blog)
    {
        return $this->form($blog->load('images'));
    }

    private function form(Blog $blog)
    {
        return renderSection('blogEditor', $blog->exists ? __('blog.edit') : __('blog.new'), null, 200, 'noindex,nofollow', [
            'article' => $blog,
        ]);
    }

    public function store(SaveBlogRequest $request): RedirectResponse
    {
        return $this->save($request, new Blog);
    }

    public function update(SaveBlogRequest $request, Blog $blog): RedirectResponse
    {
        return $this->save($request, $blog);
    }

    private function save(SaveBlogRequest $request, Blog $blog): RedirectResponse
    {
        $data = $request->validated();
        $newPaths = [];
        $removedPaths = [];
        try {
            DB::transaction(function () use ($request, &$blog, $data, &$newPaths, &$removedPaths): void {
                if ($blog->exists) {
                    $blog = Blog::whereKey($blog->id)->lockForUpdate()->firstOrFail();
                }
                $retainedCount = $blog->exists
                    ? $blog->images()->whereNotIn('id', $data['remove_images'] ?? [])->count()
                    : 0;
                if ($retainedCount + count($request->file('uploads', [])) > config('blog.max_images')) {
                    throw ValidationException::withMessages(['uploads' => __('blog.image_limit')]);
                }
                $published = $data['status'] === 'published';
                $spanish = $data['translations']['es'];
                $blog->fill([
                    'title' => $spanish['title'],
                    'content' => $spanish['content'] ?? '',
                    'seo_title' => $spanish['seo_title'] ?? null,
                    'seo_description' => $spanish['seo_description'] ?? null,
                    'seo_keywords' => $spanish['seo_keywords'] ?? null,
                    'translations' => $data['translations'],
                    'link' => $data['link'],
                    'is_published' => $published,
                    'published_at' => $published ? ($blog->published_at ?? now()) : null,
                ]);
                if (! $blog->exists) {
                    $blog->author_id = $request->user()->id;
                }
                $blog->save();

                $removed = $blog->images()->whereIn('id', $data['remove_images'] ?? [])->get();
                $removedPaths = $removed->pluck('path')->all();
                $blog->images()->whereIn('id', $removed->pluck('id'))->delete();
                foreach ($data['existing_images'] ?? [] as $id => $values) {
                    $blog->images()->whereKey($id)->update(['alt' => json_encode($values['alt'], JSON_THROW_ON_ERROR)]);
                }
                $position = (int) $blog->images()->max('position') + 1;
                foreach ($request->file('uploads', []) as $index => $upload) {
                    $path = app(UploadImageOptimizer::class)->store($upload['file'], 'images', "uploads.$index.file");
                    $newPaths[] = $path;
                    $blog->images()->create([
                        'path' => $path,
                        'alt' => $data['uploads'][$index]['alt'],
                        'position' => $position++,
                    ]);
                }
            });
        } catch (Throwable $exception) {
            $this->deleteFiles($newPaths);
            throw $exception;
        }
        $cleaned = $this->deleteFiles($removedPaths);

        return redirect()->route('admin.blog.edit', ['blog' => $blog, 'lang' => app()->getLocale()])
            ->with('status', __('blog.saved'))
            ->with('warning', $cleaned ? null : __('blog.cleanup_warning'));
    }

    public function destroy(Request $request, Blog $blog): RedirectResponse
    {
        $request->validate(['confirm_delete' => ['accepted']]);
        $paths = $blog->images()->pluck('path')->all();
        $blog->delete();
        $cleaned = $this->deleteFiles($paths);

        return redirect()->route('admin.blog.index', ['lang' => app()->getLocale()])
            ->with('status', __('blog.deleted'))
            ->with('warning', $cleaned ? null : __('blog.cleanup_warning'));
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
