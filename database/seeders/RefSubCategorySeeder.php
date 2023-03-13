<?php

namespace Database\Seeders;

use App\Models\RefCategory;
use App\Models\RefSubCategory;
use Illuminate\Database\Seeder;

class RefSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category01 = RefCategory::where('code', '01')->first();
        $category02 = RefCategory::where('code', '02')->first();
        $category03 = RefCategory::where('code', '03')->first();

        $data = [
              [
                "code" => "0101",
                "name" => "KERETA",
                "category_id" => $category01->id
              ],
              [
                "code" => "0102",
                "name" => "KENDERAAN AIR",
                "category_id" => $category01->id
              ],
              [
                "code" => "0103",
                "name" => "MOTOSIKAL",
                "category_id" => $category01->id
              ],
              [
                "code" => "0104",
                "name" => "BAS",
                "category_id" => $category01->id
              ],
              [
                "code" => "0201",
                "name" => "PERALATAN KENDALIAN MEKANIKAL",
                "category_id" => $category02->id
              ],
              [
                "code" => "0202",
                "name" => "JENTERA ANGKUT",
                "category_id" => $category02->id
              ],
              [
                "code" => "0203",
                "name" => "JENTERA KERJA AWAM",
                "category_id" => $category02->id
              ],
              [
                "code" => "0204",
                "name" => "MOBILE AERIAL PLATFORM",
                "category_id" => $category02->id
              ],
              [
                "code" => "0301",
                "name" => "LORI/TRAK",
                "category_id" => $category03->id
              ],
        ];

        RefSubCategory::insert($data);

    }
}
