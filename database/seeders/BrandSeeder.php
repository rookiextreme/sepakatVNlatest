<?php

namespace Database\Seeders;

use App\Models\RefLPembuat;
use Illuminate\Database\Seeder;
use App\Models\Vehicle\Brand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$brand =  Brand::create([
            'name' => 'Perodua'
        ]);

        $brand->vehicleModel()->insert(
            [
                [
                    'brand_id' => $brand->id,
                    'model' => 'Myvi'
                ],
                [
                    'brand_id' => $brand->id,
                    'model' => 'Ativa'
                ]
            ]
        );*/

        $brandData = [
            [
                "name" => "LAND ROVER"
            ],
            [
                "name" => "VOLVO"
            ],
            [
                "name" => "BJ"
            ],
            [
                "name" => "UD TRUCKS"
            ],
            [
                "name" => "ZETOR"
            ],
            [
                "name" => "MERCEDES BENZ"
            ],
            [
                "name" => "KOMATSU"
            ],
            [
                "name" => "ST.WAGON"
            ],
            [
                "name" => "AMMAN"
            ],
            [
                "name" => "INOKOM"
            ],
            [
                "name" => "BORA"
            ],
            [
                "name" => "BEDFORD"
            ],
            [
                "name" => "SUMITOMO"
            ],
            [
                "name" => "DAIHATSU"
            ],
            [
                "name" => "P&H"
            ],
            [
                "name" => "KIMCO"
            ],
            [
                "name" => "JOHN DEERE"
            ],
            [
                "name" => "MERCEDES"
            ],
            [
                "name" => "TIDAK BERKENAAN"
            ],
            [
                "name" => "LAIN LAIN"
            ],
            [
                "name" => "PERODUA"
            ],
            [
                "name" => "FORD"
            ],
            [
                "name" => "NISSAN"
            ],
            [
                "name" => "YELE"
            ],
            [
                "name" => "FODEN"
            ],
            [
                "name" => "BISON"
            ],
            [
                "name" => "TCM"
            ],
            [
                "name" => "MAN"
            ],
            [
                "name" => "TOYOTA"
            ],
            [
                "name" => "INGERSOLL RAND"
            ],
            [
                "name" => "ISUZU"
            ],
            [
                "name" => "EXPLOPER"
            ],
            [
                "name" => "JEEP"
            ],
            [
                "name" => "KIMCRAFT"
            ],
            [
                "name" => "SAKAI"
            ],
            [
                "name" => "MALAYSIA"
            ],
            [
                "name" => "TATA"
            ],
            [
                "name" => "DYNAPAC"
            ],
            [
                "name" => "HICOM"
            ],
            [
                "name" => "HITACHI"
            ],
            [
                "name" => "HINO"
            ],
            [
                "name" => "DONG FENG"
            ],
            [
                "name" => "JCB"
            ],
            [
                "name" => "MERCURY"
            ],
            [
                "name" => "INTER HOUGH"
            ],
            [
                "name" => "HYUNDAI"
            ],
            [
                "name" => "LAUNCH"
            ],
            [
                "name" => "CLARK"
            ],
            [
                "name" => "NAZA"
            ],
            [
                "name" => "SCANIA"
            ],
            [
                "name" => "KUBOTA"
            ],
            [
                "name" => "PACIFIC"
            ],
            [
                "name" => "KAWASAKI"
            ],
            [
                "name" => "MOBILE CRNE HYDRAULIC"
            ],
            [
                "name" => "INVECO"
            ],
            [
                "name" => "BLANWKNOX"
            ],
            [
                "name" => "LEYLAND CLIMAX"
            ],
            [
                "name" => "SUZUKI"
            ],
            [
                "name" => "YOKO"
            ],
            [
                "name" => "PROTON"
            ],
            [
                "name" => "VIBROMAX"
            ],
            [
                "name" => "DAEWOO"
            ],
            [
                "name" => "SAAB"
            ],
            [
                "name" => "CHAMPION"
            ],
            [
                "name" => "YAMAHA"
            ],
            [
                "name" => "YANMAR"
            ],
            [
                "name" => "BMC"
            ],
            [
                "name" => "GERMAN"
            ],
            [
                "name" => "FERMEC"
            ],
            [
                "name" => "AVELING BARFORD"
            ],
            [
                "name" => "HAMM"
            ],
            [
                "name" => "GRONTMIJ-CARL BRO"
            ],
            [
                "name" => "MARINI"
            ],
            [
                "name" => "CATERPILLAR"
            ],
            [
                "name" => "MITSUBISHI"
            ],
            [
                "name" => "KIA"
            ],
            [
                "name" => "VOGELE"
            ],
            [
                "name" => "MASSEY FERGUSON"
            ],
            [
                "name" => "BITELLI"
            ],
            [
                "name" => "HONDA"
            ],
            [
                "name" => "MAZDA"
            ],
            [
                "name" => "CASE"
            ],
            [
                "name" => "BOMAG"
            ],
            [
                "name" => "FIAT"
            ],
            [
                "name" => "MARINER"
            ],
            [
                "name" => "BMW"
            ],
            [
                "name" => "CHEVROLET"
            ],
            [
                "name" => "PEUGEOT"
            ],
            [
                "name" => "VOLKSWAGEN"
            ],
            [
                "name" => "AUDI"
            ],
            [
                "name" => "MAXUS/INVECO"
            ]
        ];

        Brand::insert($brandData);

        // $brandList = Brand::all();

        // foreach ($brandList as $key) {
        //     Log::info('$key->name --> '.$key->name);
        //     $findFromOriginalBrand = RefLPembuat::where('nama_pembuat', $key->name)->first();

        //     Log::info($findFromOriginalBrand);


        //     $myBrand = Brand::find($key->id);
        //     if($findFromOriginalBrand){
        //         $myBrand->update([
        //             'code' => $findFromOriginalBrand->kod_pembuat
        //         ]);
        //     }
        // }
    }
}
