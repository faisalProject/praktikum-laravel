<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $users = [
            [
                'name' => 'rigger',
                'email' => 'rigger@gmail.com',
                'email_verified_at' => now(),
                'password' => 'rigger',
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'bayu',
                'email' => 'bayu@gmail.com',
                'email_verified_at' => now(),
                'password' => 'bayu',
                'remember_token' => Str::random(10),
            ]
        ];

        // foreach ( $users as $user ) {
        //     User::create( $user );
        // }

        User::factory()->count(10)->create();

    }
}
