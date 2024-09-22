<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', Rules\Password::defaults()],
            'ra' => 'nullable|string|unique:'.User::class,
        ], [
            'ra.unique' => 'O RA informado já está em uso.',
            'ra.string' => 'O RA informado não é válido.',
            'ra.nullable' => 'O RA informado não é válido.',
            'email.unique' => 'O e-mail informado já está em uso.',
            'email.email' => 'O e-mail informado não é válido.',
            'email.lowercase' => 'O e-mail informado não é válido.',
            'email.string' => 'O e-mail informado não é válido.',
            'email.max' => 'O e-mail informado não é válido.',
            'name.required' => 'O nome informado não é válido.',
            'name.string' => 'O nome informado não é válido.',
            'name.max' => 'O nome informado não é válido.',
            'password.required' => 'A senha informada não é válida.',
            'password.string' => 'A senha informada não é válida.',
            'password.min' => 'A senha informada não é válida.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ra' => $request->ra,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
