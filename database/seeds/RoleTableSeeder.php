<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        Role::create([
            'name'     => 'admin',
            'priority' => 99999,
        ]);

        Role::create([
            'name'     => 'moderator',
            'priority' => 9999,
        ]);

        Role::create([
            'name' => 'user',
        ]);
    }
}
