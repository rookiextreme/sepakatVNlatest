<?php

namespace Database\Seeders;

use App\Models\Kenderaan\DaftarKenderaanMigrate;
use App\Models\RefCategory;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use Faker\Core\Number;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Type\Integer;

class RefSubCategoryTypeSeeder extends Seeder
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
                "code" => "010101",
                "name" => "SKID MENGEMUDI (SKID STEER)"
              ],
              [
                "name" => "SKY LIFT"
              ],
              [
                "name" => "MOTOSIKAL 2 RODA"
              ],
              [
                "name" => "KERETA SEDAN"
              ],
              [
                "name" => "BOX TRUCK"
              ],
              [
                "name" => "KREN"
              ],
              [
                "name" => "COASTER"
              ],
              [
                "name" => "Drilling Rig"
              ],
              [
                "name" => "JENTERA PEMADAT (COMPACTOR)"
              ],
              [
                "name" => "Kereta Eksekutif"
              ],
              [
                "name" => "LORI 5 TON"
              ],
              [
                "name" => "MESIN CRANE"
              ],
              [
                "name" => "PERATA TANAH (GRADER)"
              ],
              [
                "name" => "LOGI TERUP (PAVER)"
              ],
              [
                "name" => "PENGGELEK (ROLLER)"
              ],
              [
                "name" => "LORI 3 TON"
              ],
              [
                "name" => "JENTOLAK (BULLDOZER)"
              ],
              [
                "name" => "TRELER PERKHIDMATAN LOJI"
              ],
              [
                "name" => "TRAKTOR EMPAT RODA"
              ],
              [
                "name" => "JENTERA KAUT CANGKUL BELAKANG (BACKHOE)"
              ],
              [
                "name" => "TRAK PENUNDA (TOW TRUCK)"
              ],
              [
                "name" => "LORI LOADER (LOW LOADER)"
              ],
              [
                "name" => "Mesin Angkat (Lift)"
              ],
              [
                "name" => "SEMI TRELER"
              ],
              [
                "name" => "VAN"
              ],
              [
                "name" => "BAS EKSEKUTIF"
              ],
              [
                "name" => "MPV"
              ],
              [
                "name" => "TRAK PEMBUANG (DUMPER TRUCK)"
              ],
              [
                "name" => "JENGKAUT HIDROLIK (EXCAVATOR)"
              ],
              [
                "name" => "PENYODOK (SHOVEL/WHEEL LOADER)"
              ],
              [
                "name" => "PACUAN 4 RODA (4 X 4)"
              ],
              [
                "name" => "LORI PIKAP (PICK-UP)"
              ],
              [
                "name" => "Lori Kontena"
              ],
              [
                "name" => "TRAK KREN (TRUCK CRANE)"
              ],
              [
                "name" => "BOT"
              ],
              [
                "name" => "FERI"
              ],
              [
                "name" => "ROAD SWEEPER"
              ],
              [
                "name" => "BAS 24 PENUMPANG"
              ],
              [
                "name" => "BAS 40 PENUMPANG"
              ],
              [
                "name" => "LORI TANGKI (TANKER)"
              ],
              [
                "name" => "FOUR POST LIFT"
              ],
              [
                "name" => "FORKLIFT"
              ],
              [
                "name" => "LORI TIPPER (TIPPING TRUCK)"
              ],
              [
                "name" => "KERETA EKSEKUTIF"
              ],
              [
                "name" => "LORI 1 TON"
              ],
              [
                "name" => "TWO POST LIFT"
              ]
        ];

        foreach ($data as $key) {
            $findSubCategory = DaftarKenderaanMigrate::select('sub_kategori', 'jenis')->whereRaw("upper(jenis) = '".$key['name']."' ")
            ->first();

            if($findSubCategory){

                //Log::info($findSubCategory->jenis);

                $RefSubCategory = RefSubCategory::select('category_id', 'id', 'code')->whereRaw("upper(name) = '".$findSubCategory->sub_kategori."' ")
                ->first();

                $currentCount = 0;

                $currentCount = RefSubCategoryType::where([
                    'category_id' => $RefSubCategory->category_id,
                    'sub_category_id' => $RefSubCategory->id,
                ])->count();

                Log::info($currentCount);

                $number = str_pad(((int)$currentCount+1), 2, '0', STR_PAD_LEFT);

                RefSubCategoryType::insert([
                    'code' => $RefSubCategory->code.$number,
                    'name' => $findSubCategory->jenis,
                    'sub_category_id' => $RefSubCategory->id,
                    'category_id' => $RefSubCategory->category_id
                ]);

            }
        }

        //RefSubCategoryType::insert($data);
    }
}
