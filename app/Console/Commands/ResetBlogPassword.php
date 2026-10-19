<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\BlogOwnerCredentials;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetBlogPassword extends Command
{
    protected $signature = 'blog:reset-password';

    protected $description = 'Set the sole blog owner password locally, without exposing it in command arguments';

    public function handle(BlogOwnerCredentials $credentials): int
    {
        $password = $this->secret('New owner password (12-72 characters)');
        $confirmation = $this->secret('Confirm password');
        if (! is_string($password) || strlen($password) < 12 || strlen($password) > 72 || $password !== $confirmation) {
            $this->error('Passwords must match and contain 12-72 characters.');

            return self::FAILURE;
        }

        $user = User::firstOrNew(['email' => config('blog.owner_email')]);
        $user->name = $user->name ?: config('seo.profile.name');
        $user->password = Hash::make($password);
        $user->remember_token = Str::random(60);
        $user->email_verified_at = now();
        $user->save();
        $credentials->removeInitialPassword();
        $this->info('Owner password saved as a hash. Initial environment password removed. Existing authenticated sessions will expire.');

        return self::SUCCESS;
    }
}
