<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'password' => '12345678',
            'email' => 'admin@gmail.com',
            'phone_number' => '',
            'role' => UserRoleEnum::CREATOR,
            'referral_id' => random_string(),
            'last_seen' => Carbon::now()

        ]);
    }
}
