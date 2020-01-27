<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            [
                'first_name' => 'Merchant 1',
                'last_name' => 'Merchant 1',
                'email' => 'merchant1@yopmail.com',
                'password' => Hash::make(env('DEFAULT_PASSWORD')),
                'role_id' => 3,
                'mobile_number' => '09219299235',
                'establishment_name' => 'Merchant Establishment Name',
                'signup_status' => 3,
                'kyc_status' => 3,
                'is_verified' => 1,
                'is_active' => 1,
            ], [
                'first_name' => 'Admin 1',
                'last_name' => 'Admin 1',
                'email' => 'admin1@yopmail.com',
                'password' => Hash::make(env('DEFAULT_PASSWORD')),
                'role_id' => 1,
                'mobile_number' => '09219299235',
                'establishment_name' => NULL,
                'signup_status' => NULL,
                'kyc_status' => NULL,
                'is_verified' => 1,
                'is_active' => 1,
            ], [
                'first_name' => 'Super User 1',
                'last_name' => 'Super User 1',
                'email' => 'superuser1@yopmail.com',
                'password' => Hash::make(env('DEFAULT_PASSWORD')),
                'role_id' => 2,
                'mobile_number' => '09219299235',
                'establishment_name' => NULL,
                'signup_status' => NULL,
                'kyc_status' => NULL,
                'is_verified' => 1,
                'is_active' => 1,
            ]
        ]);
    }
}
