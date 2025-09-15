<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = auth()->user();

        // Employee inactive check
        $employee = \App\Models\Admin\HRM\Employee::where('personal_email', $user->email)->first();
        if ($employee && $employee->status != 1) {
            auth()->logout();
            return back()->withErrors([
                'email' => 'Your employee record is inactive. Please contact admin.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    


        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
