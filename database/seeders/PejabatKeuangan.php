<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PejabatKeuangan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Role::create(['name' => 'pembuat spj']);
        Role::create(['name' => 'pptk']);
        Role::create(['name' => 'bendahara']);
        Role::create(['name' => 'ppk-skpd']);
        Role::create(['name' => 'pa']);
    }
}
