<?php

namespace App\Http\Controllers\Jasper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Jasper;

class AssessmentVehicleCertificateController extends Controller
{
    $module = [
        'assessment_new' => 'new',
        'assessment_currvalue' => 'currvalue',
        'assessment_accident' => 'accident',
        'assessment_gov_loan' => 'gov_loan',
        'assessment_disposal' => 'disposal',
        'assessment_safety' => 'safety'
    ];
    $params = [
        'check_is_genuine_url' => Route('.redirect').'?redirectTo='.route('assessment.'.$module[$request->table_name].'.vehicle-certificate.checkGenuine'),
        'asset_path' => asset('my-assets'),
        'table_name' => $request->table_name,
        'vehicle_id' => $request->vehicle_id
    ];
    break;
}
