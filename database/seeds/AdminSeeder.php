<?php

use Illuminate\Database\Seeder;
use App\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::creat([
            'name'  => '관리자',
            'email' => 'blot',
            'password' => bcrypt('bloter_ftp'),
        ]);
    }
}
