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
            'username' => 'Enigma',
            'password' => 'ferni1386!',
            'email' => 'enigmainvest@invest.tech',
            'phone_number' => '0999999999',
            'role' => UserRoleEnum::CREATOR,
            'referral_id' => random_string(),
            'last_seen' => Carbon::now()

        ]);
    }
}
