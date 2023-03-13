<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PatchCheckAdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $usersAdmin = User::whereHas(
            'roles', function($q){
                $q->whereIn('name', ['01']);
            }
        )->whereHas('detail', function($q){
            $q->whereHas('refStatus', function($q){
                $q->where('code', '06');
            });
        })->get();

        Log::info($usersAdmin);

    }
}
