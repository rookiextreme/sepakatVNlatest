<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PatchPasswordToHash extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $query = User::whereRaw('"length"("password") = 10')->get();

        //Log::info($query);
        foreach ($query as $index => $key) {
            Log::info($key->email);
            Log::info($key->password);
            $key->update([
                'password' => Hash::make($key->password)
            ]);
        }

    }
}
