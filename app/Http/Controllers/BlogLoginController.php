<?php

namespace App\Http\Controllers;

use App\Services\BlogOwnerCredentials;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BlogLoginController extends Controller
{
    public function create(Request $request)
    {
        if ($request->user() && strcasecmp($request->user()->email, config('blog.owner_email')) === 0) {
            return redirect()->route('admin.blog.index');
        }

        return renderSection('blogLogin', __('blog.login'), null, 200, 'noindex,nofollow');
    }

    public function store(Request $request, BlogOwnerCredentials $credentials): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:254'],
            'password' => ['required', 'string', 'max:72'],
        ]);
        $user = $credentials->authenticate($data['email'], $data['password']);
        if (! $user) {
            throw ValidationException::withMessages(['email' => __('blog.invalid_login')]);
        }
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('admin.blog.index', ['lang' => app()->getLocale()]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('blog');
    }
}
