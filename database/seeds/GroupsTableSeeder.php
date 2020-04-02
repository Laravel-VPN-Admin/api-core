<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $groups = factory(\App\Models\Group::class, 20)->create();
        $group  = $groups->first();
        $user   = \App\User::query()->inRandomOrder()->first();
        $server = \App\Models\Server::query()->inRandomOrder()->first();

        /** @var \App\Models\Group $group */
        $group->users()->attach($user);
        $group->servers()->attach($server);
    }
}
