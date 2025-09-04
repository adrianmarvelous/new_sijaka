<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'pns']);
        Role::create(['name' => 'cpns']);
        Role::create(['name' => 'pppk']);
        Role::create(['name' => 'non asn']);
    }
}
