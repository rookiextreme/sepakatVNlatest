<?php

namespace App\Exports;

use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Fleet\FleetPublic;
use App\Models\Saman\MaklumatKenderaanSaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehicleSummonExport implements FromCollection, WithHeadings
{

    public $id;

    public function __construct(Request $request)
    {
        $this->id = $request->id;
        $this->fleet_view = $request->fleet_view;
    }

    public function collection()
    {
        
        $table = MaklumatKenderaanSaman::class;

        // return $table::select(
        //     'no_pendaftaran', 
        //     'a.name AS category_name',
        //     'b.desc_bm AS owner_type_name',
        //     'c.desc AS placement_name',
        //     DB::raw("CONCAT(DATE_PART('year', now()::date) - DATE_PART('year', \"acqDt\"::date), ' Tahun')"),
        //     'd.name AS brand_name',
        //     'e.name AS model_name')
        //     ->leftJoin('ref_category as a', 'a.id', '=', 'category_id')
        //     ->join('ref_owner_type as b', 'b.id', '=', 'owner_type_id')
        //     ->leftJoin('fleet.fleet_placement as c', 'c.id', '=', 'placement_id')
        //     ->leftJoin('vehicles.brands as d', 'd.id', '=', 'brand_id')
        //     ->leftJoin('vehicles.vehicle_models as e', 'e.id', '=', 'model_id')
        //     ->get();

        return $table::all();
    }
     public function headings(): array
    {
        $table = MaklumatKenderaanSaman::first();
        $attributes = array_keys($table->getAttributes());
               

        // Log::info($attributes);
        return $attributes;
        // return [
        //     'No Pendaftaran',
        //     'Kategori',
        //     'Milik',
        //     'Lokasi',
        //     'Umur',
        //     'Pengeluar',
        //     'Model'
        // ];
    }
}
