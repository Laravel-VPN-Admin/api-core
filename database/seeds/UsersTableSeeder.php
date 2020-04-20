<?php

use App\Models\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(): void
  {
//    User::truncate();
//    DB::table('role_user')->truncate();


    $adminRole = Role::where('name', 'admin')->first();
    $moderatorRole = Role::where('name', 'moderator')->first();
    $userRole = Role::where('name', 'user')->first();

    $admin = User::create([
        'name'              => 'Admin',
        'password'          => Hash::make('secret'),
        'api_token'         => \Str::random(80),
        'email'             => 'admin@laraadminvpn.com',
        'email_verified_at' => now(),
    ]);

    $king = User::create([
        'name'              => 'super-king',
        'password'          => Hash::make('test_pass'),
        'api_token'         => \Str::random(80),
        'email'             => 'king@example.com',
        'email_verified_at' => now(),
    ]);

    $moderator = User::create([
        'name'              => 'Moderator',
        'password'          => Hash::make('secret'),
        'api_token'         => \Str::random(80),
        'email'             => 'moderator@laraadminvpn.com',
        'email_verified_at' => now(),
    ]);

    $user = User::create([
        'name'              => 'User',
        'password'          => Hash::make('secret'),
        'api_token'         => \Str::random(80),
        'email'             => 'user@laraadminvpn.com',
        'email_verified_at' => now(),
    ]);

    $admin->roles()->attach($adminRole);
    $king->roles()->attach($adminRole);
    $moderator->roles()->attach($moderatorRole);
    $user->roles()->attach($userRole);

    factory(\App\User::class, 10)->create();
  }
}
