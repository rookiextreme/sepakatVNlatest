<?php

namespace App\Http\Controllers\Jasper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Jasper;

class AssessmentCertificateGovLoanController extends Controller
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
        'asset_path' => asset('my-assets'),
        'vehicle_id' => $request->vehicle_id,
    ];
    break;
}
