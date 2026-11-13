<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Lola Palparan',
            'email'    => 'lola.palparan@bulletin.test',
            'password' => Hash::make('bulletin2026'),
        ]);

        $kagawadUser = User::create([
            'name'     => 'Kagawad Luis Palparan',
            'email'    => 'kagawad.palparan@bulletin.test',
            'password' => Hash::make('bulletin2026'),
        ]);

        $kagawadAuthor = Author::where('email', 'kagawad.palparan@bulletin.test')->firstOrFail();
        $kagawadAuthor->user()->associate($kagawadUser);
        $kagawadAuthor->save();

        User::factory()->count(8)->create();
    }
}