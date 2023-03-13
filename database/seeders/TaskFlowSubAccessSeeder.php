<?php

namespace Database\Seeders;

use App\Models\TaskFlow;
use App\Models\TaskFlowSubAccess;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class TaskFlowSubAccessSeeder extends Seeder
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

            $is_verify = 0;
            $is_approval = 0;
            $is_appointment = 0;
            $is_pass = 0;

            switch ($role->name) {
                //System
                case '01':
                    break;
                //Operation
                case '02':
                    break;
                //Engineer
                case '03':
                    $is_approval = 1;
                    break;
                //Assistant Engineer
                case '04':
                    $is_appointment = 1;
                    $is_verify = 1;
                    break;
                //Public
                case '05':
                    break;
            }

            $taskflowCode01 = TaskFlow::where('code', '01')->first();
            foreach ($taskflowCode01->getListTaskFlowSub as $submodule) {

                TaskFlowSubAccess::insert([
                    'taskflow_sub_id' => $submodule->id,
                    'created_by' => 1,
                    'role_id' => $role->id,
                    'mod_fleet_verify' => $is_verify,
                    'mod_fleet_appointment' => $is_appointment,
                    'mod_fleet_approval' => $is_approval,
                    'mod_fleet_pass' => $is_pass,
                ]);
            };

            $taskflowCode02 = TaskFlow::where('code', '02')->first();
            foreach ($taskflowCode02->getListTaskFlowSub as $submodule) {

                TaskFlowSubAccess::insert([
                    'taskflow_sub_id' => $submodule->id,
                    'created_by' => 1,
                    'role_id' => $role->id,
                    'mod_fleet_verify' => $is_verify,
                    'mod_fleet_appointment' => $is_appointment,
                    'mod_fleet_approval' => $is_approval,
                    'mod_fleet_pass' => $is_pass,
                ]);
            };

            $taskflowCode03 = TaskFlow::where('code', '03')->first();
            foreach ($taskflowCode03->getListTaskFlowSub as $submodule) {

                TaskFlowSubAccess::insert([
                    'taskflow_sub_id' => $submodule->id,
                    'created_by' => 1,
                    'role_id' => $role->id,
                    'mod_fleet_verify' => $is_verify,
                    'mod_fleet_appointment' => $is_appointment,
                    'mod_fleet_approval' => $is_approval,
                    'mod_fleet_pass' => $is_pass,
                ]);
            };

            $taskflowCode04 = TaskFlow::where('code', '04')->first();
            foreach ($taskflowCode04->getListTaskFlowSub as $submodule) {

                TaskFlowSubAccess::insert([
                    'taskflow_sub_id' => $submodule->id,
                    'created_by' => 1,
                    'role_id' => $role->id,
                    'mod_fleet_verify' => $is_verify,
                    'mod_fleet_appointment' => $is_appointment,
                    'mod_fleet_approval' => $is_approval,
                    'mod_fleet_pass' => $is_pass,
                ]);
            };
        }
    }
}
