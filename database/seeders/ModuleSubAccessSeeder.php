<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\ModuleSub;
use App\Models\ModuleSubAccess;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ModuleSubAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = Role::all();
        foreach ($roles as $role) {

            $is_all = 0;
            $is_create = 0;
            $is_read = 0;
            $is_update = 0;
            $is_delete = 0;

            switch ($role->name) {
                //System
                case '01':
                    $is_all = 1;
                    $is_create = 1;
                    $is_read = 1;
                    $is_update = 1;
                    $is_delete = 1;
                    break;
                //Operation
                case '02':
                    $is_all = 1;
                    $is_create = 1;
                    $is_read = 1;
                    $is_update = 1;
                    $is_delete = 1;
                    break;
                //Engineer
                case '03':
                    $is_all = 1;
                    $is_create = 1;
                    $is_read = 1;
                    $is_update = 1;
                    $is_delete = 1;
                    break;
                //Assistant Engineer
                case '04':
                    $is_all = 1;
                    $is_create = 1;
                    $is_read = 1;
                    $is_update = 1;
                    $is_delete = 1;
                    break;
                //Public
                case '05':
                    $is_all = 1;
                    $is_create = 1;
                    $is_read = 1;
                    $is_update = 1;
                    $is_delete = 1;
                    break;
            }
            
            $moduleCode01 = Module::where('code', '01')->first();
            foreach ($moduleCode01->getListModuleSub as $submodule) {

                //saman
                if($role->name == '05' && $submodule->code == '02'){
                    $is_all = 0;
                    $is_create = 0;
                    $is_update = 0;
                    $is_delete = 0;
                }

                ModuleSubAccess::insert([
                    'module_sub_id' => $submodule->id,
                    'created_by' => 1,
                    'role_id' => $role->id,
                    'mod_fleet_a' => $is_all,
                    'mod_fleet_c' => $is_create,
                    'mod_fleet_r' => $is_read,
                    'mod_fleet_u' => $is_update,
                    'mod_fleet_d' => $is_delete,
                ]);
            };

            $moduleCode02 = Module::where('code', '02')->first();
            foreach ($moduleCode02->getListModuleSub as $submodule) {

                if($role->name == '05'){
                    $is_all = 1;
                    $is_create = 1;
                    $is_update = 1;
                    $is_delete = 1;
                }

                ModuleSubAccess::insert([
                    'module_sub_id' => $submodule->id,
                    'created_by' => 1,
                    'role_id' => $role->id,
                    'mod_fleet_a' => $is_all,
                    'mod_fleet_c' => $is_create,
                    'mod_fleet_r' => $is_read,
                    'mod_fleet_u' => $is_update,
                    'mod_fleet_d' => $is_delete,
                ]);
            };

            $moduleCode03 = Module::where('code', '03')->first();
            foreach ($moduleCode03->getListModuleSub as $submodule) {

                //Penyenggaraan
                if(in_array($role->name, ['08','10','11','12'])){
                    $is_all = 1;
                    $is_create = 1;
                    $is_update = 1;
                    $is_delete = 1;
                }

                ModuleSubAccess::insert([
                    'module_sub_id' => $submodule->id,
                    'created_by' => 1,
                    'role_id' => $role->id,
                    'mod_fleet_a' => $is_all,
                    'mod_fleet_c' => $is_create,
                    'mod_fleet_r' => $is_read,
                    'mod_fleet_u' => $is_update,
                    'mod_fleet_d' => $is_delete,
                ]);
            };

            $moduleCode04 = Module::where('code', '04')->first();
            foreach ($moduleCode04->getListModuleSub as $submodule) {

                ModuleSubAccess::insert([
                    'module_sub_id' => $submodule->id,
                    'created_by' => 1,
                    'role_id' => $role->id,
                    'mod_fleet_a' => $is_all,
                    'mod_fleet_c' => $is_create,
                    'mod_fleet_r' => $is_read,
                    'mod_fleet_u' => $is_update,
                    'mod_fleet_d' => $is_delete,
                ]);
            };

            $moduleCode05 = Module::where('code', '05')->first();
            foreach ($moduleCode05->getListModuleSub as $submodule) {

                ModuleSubAccess::insert([
                    'module_sub_id' => $submodule->id,
                    'created_by' => 1,
                    'role_id' => $role->id,
                    'mod_fleet_a' => 0,
                    'mod_fleet_c' => 0,
                    'mod_fleet_r' => 0,
                    'mod_fleet_u' => 0,
                    'mod_fleet_d' => 0,
                ]);
            };
        }

    }
}
