<?php

namespace Database\Seeders;

use A17\Twill\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TwillUserSeeder extends Seeder
{
    const DEFAULT_NAME = 'Patrick Vézina';
    const DEFAULT_EMAIL = 'patrick@area17.com';
    const DEFAULT_PASSWORD = 'secret';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();

        $user->setAttribute('name', self::DEFAULT_NAME);
        $user->setAttribute('email', self::DEFAULT_EMAIL);
        $user->setAttribute('password', Hash::make(self::DEFAULT_PASSWORD));
        $user->setAttribute('role', 'SUPERADMIN');
        $user->setAttribute('published', true);

        $user->save();
    }
}
