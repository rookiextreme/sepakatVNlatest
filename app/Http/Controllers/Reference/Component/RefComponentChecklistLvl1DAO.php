<?php

namespace App\Http\Controllers\Reference\Component;

use App\Models\Assessment\AssessmentType;
use App\Models\Maintenance\MaintenanceType;
use App\Models\RefComponentChecklistLvl1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefComponentChecklistLvl1DAO
{
    public function insert(Request $request){

        if($request->module == 'assessment'){
            $AssessmentType = AssessmentType::where('code', $request[$request->module.'_type_code'])->first();
            $queryGetLastCheckListLvl1 = RefComponentChecklistLvl1::whereHas('hasAssessmentType', function($q) use($request){
                $q->where('code', $request->assessment_type_code);
            })->orderBy('code', 'desc')->first();

            $code = 0;
            if($queryGetLastCheckListLvl1){
                $code = $queryGetLastCheckListLvl1->code;
            }

            $code = str_pad(((int)$code+1), 2, '0', STR_PAD_LEFT);

            $data = [
                'code' => $code,
                'component' => $request->name
            ];
            
            $data[$request->module.'_type_id'] = $AssessmentType->id;

        } elseif($request->module == 'maintenance'){

            $MaintenanceType = MaintenanceType::where('code', $request[$request->module.'_type_code'])->first();
            $queryGetLastCheckListLvl1 = RefComponentChecklistLvl1::whereHas('hasMaintenanceType', function($q) use($request){
                $q->where('code', $request->maintenance_type_code);
            })->orderBy('code', 'desc')->first();

            $code = 0;
            if($queryGetLastCheckListLvl1){
                $code = $queryGetLastCheckListLvl1->code;
            }

            $code = str_pad(((int)$code+1), 2, '0', STR_PAD_LEFT);

            $data = [
                'code' => $code,
                'component' => $request->name
            ];
            
            $data[$request->module.'_type_id'] = $MaintenanceType->id;

        }

        Log::info($data);

        $query = RefComponentChecklistLvl1::insert($data);

        $response = [
            'query' => $query,
            'code' => 200,
            'message' => 'Maklumat berjaya ditambah'
        ];

        Log::info($response);
        unset($response['query']);
        return $response;
    }

    public function update(Request $request){
        $id = $request->id;
        $name = $request->name;
        $query = RefComponentChecklistLvl1::find($id);
        $query->update([
            'component' => $name
        ]);

        $response = [
            'query' => $query,
            'code' => 200,
            'message' => 'Maklumat berjaya disimpan'
        ];

        Log::info($response);
        unset($response['query']);
        return $response;
    }

    public function delete(Request $request){
        $ids = $request->ids;
        Log::info($ids);
        $query = RefComponentChecklistLvl1::whereIn('id', $ids);
        $query->update([
            'status' => 0
        ]);
        Log::info($query->toSql());
        Log::info($query->get());

        $response = [
            'code' => 200,
            'message' => 'Maklumat berjaya dihapus'
        ];

        Log::info($response);
        return $response;
    }

}
