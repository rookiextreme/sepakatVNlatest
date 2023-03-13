<?php

namespace Database\Seeders;

use App\Models\RefOwnerType;
use Illuminate\Database\Seeder;

class RefOwnerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [

            [
                "code" => "01",
                "desc_bm" => "Persekutuan",
                "desc_en" => "Federal",
                "display_for" => "user_register"
            ],
            [
                "code" => "02",
                "desc_bm" => "Negeri",
                "desc_en" => "State",
                "display_for" => "user_register"
            ],
            [
                "code" => "01",
                "desc_bm" => "Persekutuan",
                "desc_en" => "Federal",
                "display_for" => "vehicle_register"
            ],
            [
                "code" => "02",
                "desc_bm" => "Negeri",
                "desc_en" => "State",
                "display_for" => "vehicle_register"
            ],
            [
                "code" => "03",
                "desc_bm" => "Projek",
                "desc_en" => "Project",
                "display_for" => "vehicle_register"
            ]

        ];
        for ($i=0; $i <count($data); $i++) {
            $data[$i]['desc_bm'] = strtoupper($data[$i]['desc_bm']);
            $data[$i]['desc_en'] = strtoupper($data[$i]['desc_en']);
            RefOwnerType::create($data[$i]);
        }

    }
}
