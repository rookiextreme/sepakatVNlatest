<?php

namespace App\Http\Controllers\Assessment\Depreciation;

use App\Http\Controllers\Controller;
use App\Models\Fleet\FleetAudit;
use App\Models\Fleet\FleetDepartment;
use App\Models\RefCategory;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPJasper\PHPJasper;



class VehicleDepreciationDAO extends Controller
{


    public function getDataByKelas($kelas){


        // dd($composition_by);
        Log::info('issued_by --> '.$kelas);

        $query = DB::select(DB::raw('
        SELECT rksn.nombor_kelas AS class_number, rksn.roman_numbering AS roman_numbering, rksn.desc AS class_name, ksn.percentage AS percentage, ksn.age AS age
        FROM vehicles.kelas_susut_nilai ksn
        JOIN vehicles.ref_kelas_susut_nilai rksn ON rksn.nombor_kelas = ksn.nombor_kelas
        WHERE ksn.status IS true AND ksn.nombor_kelas = ?
        ORDER BY age ASC
        '),[$kelas]);

        //Log::info($query);
        return $query;


    }

    public function getKelasKenderaan($brand_id){

        $query = DB::select(DB::raw('
        SELECT rksn.nombor_kelas AS class_number, rksn.roman_numbering AS roman_numbering, rksn.desc, b.name AS vehicle_name, age AS age, rksn.nombor_kelas AS class_number, rksn.roman_numbering AS class_id, b.id AS vehicle_id
        FROM vehicles.kelas_kenderaan_susut_nilai ksn
        JOIN vehicles.brands b ON b.id = ksn.brand_id
        JOIN vehicles.ref_kelas_susut_nilai rksn ON rksn.nombor_kelas = ksn.nombor_kelas
        WHERE ksn.brand_id = ?
        ORDER BY vehicle_name, age ASC
        '),[$brand_id]);

        //Log::info($query);
        return $query;


    }
    public function getKelas(){


        // dd($composition_by);

        $query = DB::select(DB::raw('
        SELECT nombor_kelas AS kelas_id, roman_numbering FROM vehicles.ref_kelas_susut_nilai WHERE status IS true ORDER BY nombor_kelas
        '));

        //Log::info($query);
        return $query;


    }

    public function getKenderaan(){

        $query = DB::select(DB::raw('
        SELECT DISTINCT ksn.brand_id, b.name FROM vehicles.kelas_kenderaan_susut_nilai ksn
        JOIN vehicles.brands b ON b.id=ksn.brand_id
        WHERE ksn.status IS true
        AND ksn.is_active IS true
        ORDER BY b.name ASC
        '));

        //Log::info($query);
        return $query;


    }

    // public function getKelasKenderaan($brand_id){

    //     $query = DB::select(DB::raw('
    //     SELECT b.name AS vehicle_name, age AS age, rksn.nombor_kelas AS class_number, rksn.roman_numbering AS class_id, b.id AS vehicle_id
    //     FROM vehicles.kelas_kenderaan_susut_nilai ksn
    //     JOIN vehicles.brands b ON b.id = ksn.brand_id
    //     JOIN vehicles.ref_kelas_susut_nilai rksn ON rksn.nombor_kelas = ksn.nombor_kelas
    //     WHERE ksn.brand_id = ?
    //     ORDER BY vehicle_name, age ASC
    //     '),[$brand_id]);

    //     //Log::info($query);
    //     return $query;


    // }

    public function getKenderaanNotYetDefined(){

        $query = DB::select(DB::raw('
        SELECT DISTINCT b.id AS vehicle_id, b.name AS vehicle_name FROM vehicles.brands b
        WHERE b.id NOT IN (SELECT ksn.brand_id FROM vehicles.kelas_kenderaan_susut_nilai ksn WHERE ksn.status IS true)
        ORDER BY b.name ASC
        '));

        //Log::info($query);
        return $query;


    }

    public function getAllKenderaan(){

        $query = DB::select(DB::raw('
        SELECT DISTINCT b.id AS vehicle_id, b.name AS vehicle_name
        FROM vehicles.kelas_kenderaan_susut_nilai kksn
        JOIN vehicles.brands b ON b.id=kksn.brand_id
        WHERE kksn.status IS true
        ORDER BY b.name ASC
        '));

        //Log::info($query);
        return $query;


    }

    public function getCurrentHighestClass(){

        $query = DB::select(DB::raw('
        SELECT MAX(nombor_kelas) AS highest_class FROM vehicles.ref_kelas_susut_nilai WHERE status IS true LIMIT 1
        '));

        //Log::info($query);

        $highest_class = $query[0] -> highest_class;

        return $highest_class+1;


    }

    public function numberToRomanRepresentation($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }


    public function updatePercentageClass($classNumberData, $classAgeData, $classPercentage){

        $returnValue = DB::update('
        UPDATE vehicles.kelas_susut_nilai ksn SET percentage = ?  WHERE nombor_kelas = ? AND age = ? '
        , [$classPercentage, $classNumberData, $classAgeData]);

        Log::info('returnValue : '.$returnValue);

        return $returnValue;


    }

    public function updateVehicleClass($vehicleId, $vehicleAge, $vehicleClass){
        Log::info("masuk function updateVehicleClass");
        $returnValue = DB::update('
        UPDATE vehicles.kelas_kenderaan_susut_nilai kksn SET nombor_kelas = ?  WHERE brand_id = ? AND age = ? '
        , [$vehicleClass, $vehicleId, $vehicleAge]);

        Log::info('returnValue : '.$returnValue);

        return $returnValue;


    }

    public function addVehicleClass($vehicleId, $vehicleClass, $age){

        $returnValue = DB::insert('
        INSERT INTO vehicles.kelas_kenderaan_susut_nilai(brand_id, nombor_kelas, age, status)
        VALUES(?, ?, ?, true) '
        , [$vehicleId, $vehicleClass, $age]);

        Log::info('returnValue : '.$returnValue);

        return $returnValue;


    }

    public function addClass($latestClass, $latestClassInRoman, $latestClassDesc){

        $returnValue = DB::insert('
        INSERT INTO vehicles.ref_kelas_susut_nilai(nombor_kelas, "desc", roman_numbering, status)
        VALUES(?, ?, ?, true) '
        , [$latestClass, $latestClassDesc, $latestClassInRoman]);

        Log::info('returnValue : '.$returnValue);

        return $returnValue;


    }

    public function addClassPercentage($latestClass, $age, $percentage){

        $returnValue = DB::insert('
        INSERT INTO vehicles.kelas_susut_nilai(nombor_kelas, age, percentage, status)
        VALUES(?, ?, ?, true) '
        , [$latestClass, $age, $percentage]);

        Log::info('returnValue : '.$returnValue);

        return $returnValue;


    }

    public function getResultDepreciation($modelId, $age){

        $query = DB::select(DB::raw('
        SELECT rksn.desc AS className, ksn.percentage AS percentage
        FROM vehicles.kelas_kenderaan_susut_nilai kksn
        JOIN vehicles.ref_kelas_susut_nilai rksn ON rksn.nombor_kelas = kksn.nombor_kelas
        JOIN vehicles.kelas_susut_nilai ksn ON ksn.nombor_kelas = kksn.nombor_kelas
        WHERE kksn.status IS true AND kksn.age = ? AND kksn.brand_id = ?
        AND ksn.age = ?
        LIMIT 1
        '),[$age, $modelId, $age]);

        //Log::info('query  : '.$query);

        return $query;


    }

    public function getResultDepreciationModelNoRecord($age, $classNumber){

        $query = DB::select(DB::raw('
        SELECT rksn.desc AS className, ksn.percentage AS percentage
        FROM vehicles.kelas_susut_nilai ksn
        JOIN vehicles.ref_kelas_susut_nilai rksn ON rksn.nombor_kelas = ksn.nombor_kelas
        WHERE ksn.status IS true AND ksn.age = ? AND ksn.nombor_kelas = ?


        '),[$age, $classNumber]);

        //Log::info('query  : '.$query);

        return $query;


    }

    public function checkIfVehicleBrandExistInDepreciationRecord($brandId){

        $query = DB::select(DB::raw('
        SELECT 1 AS exist
        FROM vehicles.kelas_kenderaan_susut_nilai
        WHERE brand_id = ? AND status IS true

        '),[$brandId]);

        //Log::info($query);
        return $query;


    }




}
