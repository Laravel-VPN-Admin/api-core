<?php

use App\Models\Group;
use App\Models\Server;
use App\Models\User;
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
        $groups = factory(Group::class, 20)->create();
        $group  = $groups->first();
        $user   = User::query()->inRandomOrder()->first();
        $server = Server::query()->inRandomOrder()->first();

        /** @var \App\Models\Group $group */
        $group->users()->attach($user);
        $group->servers()->attach($server);
    }
}
