<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
                'password' => ['required'],
                'cpf' => 'required|string|min_digits:11|max_digits:11|unique:' . User::class,
            ], [
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
                'cpf.unique' => 'O CPF informado já está em uso.',
                'cpf.string' => 'O CPF informado não é válido.',
                'cpf.min_digits' => 'O CPF informado não é válido.',
                'cpf.max_digits' => 'O CPF informado não é válido.',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'cpf' => $request->cpf,
                'ra' => $request->ra,
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('dashboard', absolute: false));
        } catch (\Exception $e) {
            Log::error('Erro: ' . $e);
            return redirect(route('home', absolute: false))->with('error', 'Erro ao cadastrar usuário.');
        }
    }
}
