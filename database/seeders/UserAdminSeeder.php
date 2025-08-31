<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserAdminSeeder extends Seeder
{
    public function run(): void
    {
        $password = app()->environment('local') ? 'placeholder' : 'nJGrKXwD459mEp';

        User::create([
            'name' => 'Admin',
            'email' => 'admin@softweek.com.br',
            'email_verified_at' => now(),
            'is_admin' => true,
            'password' => $password,
        ]);
    }
}
