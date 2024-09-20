<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $d = new User;
        $d->name = 'superadmin';
        $d->username = 'superadmin';
        $d->email = 'superadmin@gmail.com';
        $d->password = bcrypt('admin');
        $d->save();
    }
}
