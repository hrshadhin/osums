<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('going to seed user table....');
        $this->call(UserTableSeeder::class);
		$this->command->info('user table seeded.');

    }
}
