<?php

namespace Database\Seeders;

use App\Models\ModuleSub;
use App\Models\ModuleSubAccess;
use App\Models\RefRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class PatchModuleSubAccess22032022 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        ini_set('memory_limit', '512M');

        //Module Vehicle
        $submodule_vehicle_list = ModuleSub::where([
            'code' => '03'
        ])->whereHas('hasModule', function($q){
            $q->where('code', '01');
        })->get();

        ModuleSubAccess::whereHas('underModuleSub', function($q){
            $q->whereHas('hasModule', function($q2){
                $q2->where('code', '01');
            })->where('code', '03');
        })->delete();

        //Module Assessment
        $submodule_assessment_list = ModuleSub::where([
            'code' => '07'
        ])->whereHas('hasModule', function($q){
            $q->where('code', '02');
        })->get();

        ModuleSubAccess::whereHas('underModuleSub', function($q){
            $q->whereHas('hasModule', function($q2){
                $q2->where('code', '02');
            })->where('code', '07');
        })->delete();

        //Module Maintenance
        $submodule_maintenance_list = ModuleSub::where([
            'code' => '03'
        ])->whereHas('hasModule', function($q){
            $q->where('code', '03');
        })->get();

        ModuleSubAccess::whereHas('underModuleSub', function($q){
            $q->whereHas('hasModule', function($q2){
                $q2->where('code', '03');
            })->where('code', '03');
        })->delete();

        //Module Logistic
        $submodule_logistic_list = ModuleSub::where([
            'code' => '03'
        ])->whereHas('hasModule', function($q){
            $q->where('code', '04');
        })->get();

        ModuleSubAccess::whereHas('underModuleSub', function($q){
            $q->whereHas('hasModule', function($q2){
                $q2->where('code', '04');
            })->where('code', '03');
        })->delete();

        $roles = RefRole::all();
        foreach ($roles as $role) {

            $mod_fleet_r = 0;

            Log::info($role->code);

            if($role->code == '01'){
                $mod_fleet_r = 1;
            }

            //vehicle
            foreach ($submodule_vehicle_list as $key => $submodule) {

                ModuleSubAccess::insert([
                    'module_sub_id' => $submodule->id,
                    'created_by' => 1,
                    'role_id' => $role->id,
                    'mod_fleet_a' => 0,
                    'mod_fleet_c' => 0,
                    'mod_fleet_r' => $mod_fleet_r,
                    'mod_fleet_u' => 0,
                    'mod_fleet_d' => 0,
                ]);
            }

            //assessment
            foreach ($submodule_assessment_list as $key => $submodule) {

                ModuleSubAccess::insert([
                    'module_sub_id' => $submodule->id,
                    'created_by' => 1,
                    'role_id' => $role->id,
                    'mod_fleet_a' => 0,
                    'mod_fleet_c' => 0,
                    'mod_fleet_r' => $mod_fleet_r,
                    'mod_fleet_u' => 0,
                    'mod_fleet_d' => 0,
                ]);
            }

            //maintennace
            foreach ($submodule_maintenance_list as $key => $submodule) {

                ModuleSubAccess::insert([
                    'module_sub_id' => $submodule->id,
                    'created_by' => 1,
                    'role_id' => $role->id,
                    'mod_fleet_a' => 0,
                    'mod_fleet_c' => 0,
                    'mod_fleet_r' => $mod_fleet_r,
                    'mod_fleet_u' => 0,
                    'mod_fleet_d' => 0,
                ]);
            }

            //logistic
            foreach ($submodule_logistic_list as $key => $submodule) {

                ModuleSubAccess::insert([
                    'module_sub_id' => $submodule->id,
                    'created_by' => 1,
                    'role_id' => $role->id,
                    'mod_fleet_a' => 0,
                    'mod_fleet_c' => 0,
                    'mod_fleet_r' => $mod_fleet_r,
                    'mod_fleet_u' => 0,
                    'mod_fleet_d' => 0,
                ]);
            }

        };

    }
}
