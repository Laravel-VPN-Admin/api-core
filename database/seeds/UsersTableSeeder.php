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
        $user                    = new \App\User();
        $user->name              = 'super-king';
        $user->password          = Hash::make('test_pass');
        $user->email             = 'king@example.com';
        $user->email_verified_at = now();
        $user->save();

        factory(\App\User::class, 50)->create();
    }
}
