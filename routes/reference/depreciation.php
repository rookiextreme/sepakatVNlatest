<?php

use App\Http\Controllers\Reference\Vehicle\Engine\RefEngineTypeDAO;

use App\Models\RefEngineType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/depreciation', function () {

    $Brand = DB::select(DB::raw('
        SELECT distinct b.code AS brand_code, b.name AS brand_name, b.id AS brand_id, ksn.is_active as active
        FROM vehicles.brands b 
        JOIN vehicles.kelas_kenderaan_susut_nilai ksn ON ksn.brand_id = b.id 
        ORDER BY brand_code
    '));
    return view('reference.depreciation.depreciation', [
        'Brand' => $Brand,
    ]);
    
})->name('.depreciation');

Route::post('is-active-update', function(Request $request){

    $query = DB::update('
    UPDATE vehicles.kelas_kenderaan_susut_nilai kksn SET is_active = ?  WHERE brand_id = ? '
    , [$request->active_value, $request->brand_id]);
    
    Log::info($request->active_value);
    Log::info($request->brand_id);
    Log::info($query);

    return $query;

})->name('.depreciation.update');
?>