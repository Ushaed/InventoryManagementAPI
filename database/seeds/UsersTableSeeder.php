<?php

use App\User;
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
        factory(User::class,10)->create();
        $user = new User([
            'name'=>'Md Ushaed',
            'email'=>'admin@admin.com',
            'first_name'=>'Md',
            'last_name'=>'ushaed',
            'phone'=>'01761963922',
            'gender'=>1,
            'user_type'=>'manager',
            'password'=>bcrypt('12345678')
        ]);
        $user->save();
    }
}
