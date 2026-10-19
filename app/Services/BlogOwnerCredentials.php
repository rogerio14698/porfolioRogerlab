<?php

namespace App\Services;

use App\Models\User;
use Dotenv\Dotenv;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class BlogOwnerCredentials
{
    public function authenticate(string $email, string $password): ?User
    {
        if (strcasecmp($email, config('blog.owner_email')) !== 0) {
            return null;
        }

        File::ensureDirectoryExists(storage_path('app/private'));
        $lock = fopen(storage_path('app/private/blog-owner.lock'), 'c');
        if ($lock === false) {
            throw new RuntimeException('Cannot lock the blog owner credential store.');
        }
        if (! flock($lock, LOCK_EX)) {
            fclose($lock);
            throw new RuntimeException('Cannot lock the blog owner credential store.');
        }

        try {
            $user = User::where('email', config('blog.owner_email'))->first();
            if ($user) {
                if (! Hash::check($password, $user->password)) {
                    return null;
                }
                $this->removeInitialPassword();

                return $user;
            }

            $path = app()->environmentFilePath();
            $values = is_file($path) ? Dotenv::parse(File::get($path)) : [];
            $initial = (string) ($values['BLOG_INITIAL_PASSWORD'] ?? '');
            if (strlen($initial) < 12 || strlen($initial) > 72 || strpbrk($initial, "\r\n") !== false || ! hash_equals($initial, $password)) {
                return null;
            }

            return DB::transaction(function () use ($password): User {
                $user = User::create([
                    'name' => config('seo.profile.name'),
                    'email' => config('blog.owner_email'),
                    'password' => Hash::make($password),
                ]);
                $this->removeInitialPassword();

                return $user;
            });
        } finally {
            flock($lock, LOCK_UN);
            fclose($lock);
        }
    }

    public function removeInitialPassword(): void
    {
        $path = app()->environmentFilePath();
        if (! is_file($path)) {
            return;
        }
        $original = File::get($path);
        $pattern = <<<'REGEX'
~^[ \t]*(?:export[ \t]+)?BLOG_INITIAL_PASSWORD[ \t]*=[ \t]*(?:"(?:\\.|[^"\\])*"|'[^']*'|[^\r\n]*)[ \t]*(?:\#[^\r\n]*)?(?:\r?\n|$)~m
REGEX;
        $clean = preg_replace($pattern, '', $original);
        if ($clean === null) {
            throw new RuntimeException('Cannot remove the initial blog password.');
        }
        if ($original === $clean) {
            return;
        }
        if (array_key_exists('BLOG_INITIAL_PASSWORD', Dotenv::parse($clean))) {
            throw new RuntimeException('The initial blog password could not be completely removed.');
        }
        $temporary = tempnam(dirname($path), '.blog-env-');
        if ($temporary === false) {
            throw new RuntimeException('Cannot prepare the environment update.');
        }
        try {
            if (file_put_contents($temporary, $clean, LOCK_EX) !== strlen($clean)) {
                throw new RuntimeException('Cannot write the updated environment.');
            }
            if (! chmod($temporary, fileperms($path) & 0777) || ! rename($temporary, $path)) {
                throw new RuntimeException('Cannot replace the environment. Check its write permissions.');
            }
        } finally {
            if (is_file($temporary)) {
                File::delete($temporary);
            }
        }
    }
}
