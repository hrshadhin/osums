<?php

use Illuminate\Database\Seeder;
use App\User;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('users')->delete();

        User::create(array('firstname'=>'Mr.','lastname'=>'Admin','login'=>'admin','email' => 'admin@university.dev','group'=>'Admin',"password"=> "123456"));
        User::create(array('firstname'=>'Mr.','lastname'=>'Other','login'=>'other','email' => 'other@university.dev','group'=>'Other',"password"=> "123456"));
    }
}
