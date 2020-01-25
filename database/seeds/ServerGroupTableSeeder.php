<?php

use Illuminate\Database\Seeder;

class ServerGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\ServerGroup::class, 20)->create();
    }
}
