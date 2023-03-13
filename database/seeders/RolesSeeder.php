<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => '01']);
        Role::create(['name' => '02']);
        Role::create(['name' => '03']);
        Role::create(['name' => '04']);
        Role::create(['name' => '05']);
        Role::create(['name' => '06']);
        Role::create(['name' => '07']);
        Role::create(['name' => '08']);
        Role::create(['name' => '09']);
        Role::create(['name' => '10']);
        Role::create(['name' => '11']);
        Role::create(['name' => '12']);
        Role::create(['name' => '13']);
        Role::create(['name' => '14']);
        Role::create(['name' => '15']);
        // Role::create(['name' => '16']);

    }
}
