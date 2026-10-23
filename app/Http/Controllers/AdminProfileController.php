<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveProfileRequest;
use App\Models\Project;
use App\Models\SiteProfile;
use App\Services\UploadImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\UnableToDeleteFile;
use Throwable;

class AdminProfileController extends Controller
{
    public function dashboard()
    {
        return renderSection('adminDashboard', __('profile.admin.dashboard'), null, 200, 'noindex,nofollow');
    }

    public function edit()
    {
        return renderSection('profileEditor', __('profile.admin.profile'), null, 200, 'noindex,nofollow', [
            'siteProfile' => SiteProfile::current()->load('proofProjects'),
            'proofProjects' => Project::orderBy('position')->orderBy('id')->get(),
        ]);
    }

    public function update(SaveProfileRequest $request, UploadImageOptimizer $optimizer)
    {
        $data = $request->validated();
        $newPath = null;
        $removedPath = null;
        try {
            if ($request->hasFile('photo')) {
                $newPath = $optimizer->store($request->file('photo'), 'profile', 'photo');
            }
            DB::transaction(function () use ($data, $newPath, &$removedPath): void {
                $profile = SiteProfile::whereKey(1)->lockForUpdate()->firstOrFail();
                $profile->fill(collect($data)->except([
                    'photo', 'offer1_project_ids', 'offer2_project_ids', 'offer3_project_ids',
                ])->all());
                if ($newPath !== null) {
                    $removedPath = $profile->photo_path;
                    $profile->photo_path = $newPath;
                    $profile->photo_enabled = true;
                    $profile->photo_is_default = false;
                }
                $profile->save();
                foreach (range(1, 3) as $area) {
                    $profile->projectsForArea($area)->sync($data["offer{$area}_project_ids"] ?? []);
                }
            });
        } catch (Throwable $exception) {
            $this->deleteFile($newPath);
            throw $exception;
        }

        return $this->redirect(__('profile.admin.saved'), $this->deleteFile($removedPath));
    }

    public function destroyPhoto(Request $request)
    {
        $request->validate(['confirm_delete' => ['accepted']]);
        $path = DB::transaction(function () {
            $profile = SiteProfile::whereKey(1)->lockForUpdate()->firstOrFail();
            $path = $profile->photo_path;
            $profile->update(['photo_path' => null, 'photo_enabled' => false, 'photo_is_default' => false]);

            return $path;
        });

        return $this->redirect(__('profile.admin.deleted'), $this->deleteFile($path));
    }

    public function destroyResearch(Request $request)
    {
        $request->validate(['confirm_delete' => ['accepted']]);
        DB::transaction(function (): void {
            $profile = SiteProfile::whereKey(1)->lockForUpdate()->firstOrFail();
            $translations = $profile->translations;
            foreach (config('blog.locales') as $locale) {
                foreach (['research_title', 'research_body', 'research_link'] as $field) {
                    $translations[$locale][$field] = '';
                }
            }
            $profile->update(['translations' => $translations, 'research_enabled' => false]);
        });

        return $this->redirect(__('profile.admin.deleted'));
    }

    private function redirect(string $message, bool $cleaned = true)
    {
        return redirect()->route('admin.profile.edit', ['lang' => app()->getLocale()])
            ->with('status', $message)->with('warning', $cleaned ? null : __('blog.cleanup_warning'));
    }

    private function deleteFile(?string $path): bool
    {
        if ($path === null) {
            return true;
        }
        try {
            $deleted = Storage::disk('blog')->delete($path);
            if (! $deleted) {
                report(new \RuntimeException('Unable to delete replaced profile image.'));
            }

            return $deleted;
        } catch (UnableToDeleteFile $exception) {
            report($exception);

            return false;
        }
    }
}
