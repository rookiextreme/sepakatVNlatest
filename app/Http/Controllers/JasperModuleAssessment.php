<?php

use App\Models\Assessment\AssessmentAccidentVehicle;
use App\Models\Assessment\AssessmentCurrvalue;
use App\Models\Assessment\AssessmentCurrvalueVehicle;
use App\Models\Assessment\AssessmentFormCheckLvl1;
use App\Models\Assessment\AssessmentGovLoan;
use App\Models\Assessment\AssessmentGovLoanVehicle;
use App\Models\Assessment\AssessmentNew;
use App\Models\Assessment\AssessmentNewVehicle;
use App\Models\Assessment\AssessmentSafety;
use App\Models\Assessment\AssessmentSafetyVehicle;
use App\Models\Assessment\AssessmentType;
use App\Models\Maintenance\MaintenanceEvaluationLetter;
use App\Models\Maintenance\MaintenanceJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

$carbon = new Carbon();
$carbon->setLocale('ms');

switch ($reportName) {
    case 'assessment_vehicle_certificate':
        $str = "WP";
        $AssessmentNewVehicle = AssessmentNewVehicle::find($request->vehicle_id);
        $AssessmentNew = AssessmentNew::find($AssessmentNewVehicle->assessment_new_id);
        $date = Carbon::parse($AssessmentNewVehicle->assessment_dt)->translatedFormat('d F Y');
        $checkApp = Carbon::parse($AssessmentNewVehicle->assessment_dt)->translatedFormat('d F Y');

        // $woksyop_state = str_replace($str, "", $AssessmentNew->hasWorkShop->hasState->desc);
        if($AssessmentNewVehicle->hasAssessmentDetail->hasWorkShop->hasState->code == '14'){
            $woksyop_state = "BAHAGIAN PERKHIDMATAN MEKANIKAL \n CAWANGAN KEJURUTERAAN MEKANIKAL \n IBU PEJABAT JKR MALAYSIA";
            $branch_workshop_state = "BAHAGIAN PERKHIDMATAN MEKANIKAL, CAWANGAN KEJURUTERAAN MEKANIKAL, IBU PEJABAT JKR MALAYSIA";
            $state_of_woksyop = "BAHAGIAN PERKHIDMATAN MEKANIKAL CKM IP JKR";
        }
        else {
            $woksyop_state =  "CAWANGAN KEJURUTERAAN MEKANIKAL \n NEGERI ".$AssessmentNewVehicle->hasAssessmentDetail->hasWorkShop->hasState->desc;
            $branch_workshop_state = "CAWANGAN KEJURUTERAAN MEKANIKAL <br/> NEGERI " .$AssessmentNewVehicle->hasAssessmentDetail->hasWorkShop->hasState->desc;

                if(($AssessmentNewVehicle->hasAssessmentDetail->hasWorkShop->hasState->code == '05') ||
                ($AssessmentNewVehicle->hasAssessmentDetail->hasWorkShop->hasState->code == '15') ||
                ($AssessmentNewVehicle->hasAssessmentDetail->hasWorkShop->hasState->code == '16')){
                    $state_of_woksyop = $AssessmentNewVehicle->hasAssessmentDetail->hasWorkShop->hasState->desc;
                }
                else{
                    $state_of_woksyop = "NEGERI "  .$AssessmentNewVehicle->hasAssessmentDetail->hasWorkShop->hasState->desc;
                }
        }

        $module = [
            'assessment_new' => 'new',
            'assessment_currvalue' => 'currvalue',
            'assessment_accident' => 'accident',
            'assessment_gov_loan' => 'gov_loan',
            'assessment_disposal' => 'disposal',
            'assessment_safety' => 'safety'
        ];

        $params = [
            // 'check_is_genuine_url' => Route('.redirect').'?redirectTo='.route('assessment.'.$module[$request->table_name].'.vehicle-certificate.checkGenuine'),
            'check_is_genuine_url' => route('assessment.'.$module[$request->table_name].'.vehicle-certificate.checkGenuine'),
            'asset_path' => public_path('my-assets'),
            'table_name' => $request->table_name,
            'vehicle_id' => $request->vehicle_id,
            'tarikh_periksa' => $checkApp,
            'woksyop_state' => $woksyop_state,
            'state_of_woksyop' => $state_of_woksyop,
            'branch_workshop_state' => $branch_workshop_state
        ];
        break;

    case 'assessment_certificate_safety':

        $AssessmentSafetyVehicle = AssessmentSafetyVehicle::find($request->vehicle_id);

        // $woksyop_state = str_replace($str, "", $AssessmentNew->hasWorkShop->hasState->desc);
        if($AssessmentSafetyVehicle->hasAssessmentDetail->hasWorkShop->hasState->code == '14'){
            $woksyop_state = "BAHAGIAN PERKHIDMATAN MEKANIKAL \n CAWANGAN KEJURUTERAAN MEKANIKAL \n IBU PEJABAT JKR MALAYSIA";
            $branch_workshop_state = "BAHAGIAN PERKHIDMATAN MEKANIKAL, CAWANGAN KEJURUTERAAN MEKANIKAL, IBU PEJABAT JKR MALAYSIA";
            $state_of_woksyop = "BAHAGIAN PERKHIDMATAN MEKANIKAL CKM IP JKR";
        } else {
            $woksyop_state =  "CAWANGAN KEJURUTERAAN MEKANIKAL \n NEGERI ".$AssessmentSafetyVehicle->hasAssessmentDetail->hasWorkShop->hasState->desc;
            $branch_workshop_state = "CAWANGAN KEJURUTERAAN MEKANIKAL <br/> NEGERI " .$AssessmentSafetyVehicle->hasAssessmentDetail->hasWorkShop->hasState->desc;

                if(($AssessmentSafetyVehicle->hasAssessmentDetail->hasWorkShop->hasState->code == '05') ||
                ($AssessmentSafetyVehicle->hasAssessmentDetail->hasWorkShop->hasState->code == '15') ||
                ($AssessmentSafetyVehicle->hasAssessmentDetail->hasWorkShop->hasState->code == '16')){
                    $state_of_woksyop = $AssessmentSafetyVehicle->hasAssessmentDetail->hasWorkShop->hasState->desc;
                }
                else{
                    $state_of_woksyop = "NEGERI "  .$AssessmentSafetyVehicle->hasAssessmentDetail->hasWorkShop->hasState->desc;
                }
        }

        $future_date = Carbon::parse($AssessmentSafetyVehicle->expiry_dt);
        $date = Carbon::parse($AssessmentSafetyVehicle->assessment_dt)->translatedFormat('d F Y');
        $checkApp = Carbon::parse($AssessmentSafetyVehicle->assessment_dt)->translatedFormat('d F Y');

        $module = [
            'assessment_new' => 'new',
            'assessment_currvalue' => 'currvalue',
            'assessment_accident' => 'accident',
            'assessment_gov_loan' => 'gov_loan',
            'assessment_disposal' => 'disposal',
            'assessment_safety' => 'safety'
        ];

        $params = [
            'assessment_vehicle_safety_id' => $request->vehicle_id,
            'future_date' => Carbon::parse($future_date)->translatedFormat('d/m/Y'),
            'asset_path' => public_path('my-assets'),
            // 'check_is_genuine_url' => Route('.redirect').'?redirectTo='.route('assessment.'.$module["assessment_safety"].'.vehicle-certificate.checkGenuine'),
            'check_is_genuine_url' => route('assessment.'.$module[$request->table_name].'.vehicle-certificate.checkGenuine'),
            'tarikh_periksa' => $checkApp,
            'woksyop_state' => $woksyop_state,
            'state_of_woksyop' => $state_of_woksyop,
            'branch_workshop_state' => $branch_workshop_state
        ];
        break;

    case 'assessment_certificate_currvalue':
        $AssessmentCurrvalueVehicle = AssessmentCurrvalueVehicle::find($request->vehicle_id);

        // $woksyop_state = str_replace($str, "", $AssessmentNew->hasWorkShop->hasState->desc);
        if($AssessmentCurrvalueVehicle->hasAssessmentDetail->hasWorkShop->hasState->code == '14'){
            $woksyop_state = "BAHAGIAN PERKHIDMATAN MEKANIKAL \n CAWANGAN KEJURUTERAAN MEKANIKAL \n IBU PEJABAT JKR MALAYSIA";
            $branch_workshop_state = "BAHAGIAN PERKHIDMATAN MEKANIKAL, CAWANGAN KEJURUTERAAN MEKANIKAL, IBU PEJABAT JKR MALAYSIA";
            $state_of_woksyop = "BAHAGIAN PERKHIDMATAN MEKANIKAL CKM IP JKR";
        } else {
            $woksyop_state =  "CAWANGAN KEJURUTERAAN MEKANIKAL \n NEGERI ".$AssessmentCurrvalueVehicle->hasAssessmentDetail->hasWorkShop->hasState->desc;
            $branch_workshop_state = "CAWANGAN KEJURUTERAAN MEKANIKAL <br/> NEGERI " .$AssessmentCurrvalueVehicle->hasAssessmentDetail->hasWorkShop->hasState->desc;

                if(($AssessmentCurrvalueVehicle->hasAssessmentDetail->hasWorkShop->hasState->code == '05') ||
                ($AssessmentCurrvalueVehicle->hasAssessmentDetail->hasWorkShop->hasState->code == '15') ||
                ($AssessmentCurrvalueVehicle->hasAssessmentDetail->hasWorkShop->hasState->code == '16')){
                    $state_of_woksyop = $AssessmentCurrvalueVehicle->hasAssessmentDetail->hasWorkShop->hasState->desc;
                }
                else{
                    $state_of_woksyop = "NEGERI "  .$AssessmentCurrvalueVehicle->hasAssessmentDetail->hasWorkShop->hasState->desc;
                }
        }
        $f = new NumberFormatter("ms", NumberFormatter::SPELLOUT);
        if($AssessmentCurrvalueVehicle->evaluation_currvalue_type == "3" || $AssessmentCurrvalueVehicle->evaluation_currvalue_type == "4"){
            $multiple = $AssessmentCurrvalueVehicle->metal_price * $AssessmentCurrvalueVehicle->metal_weight;
            $multiple2 = round($multiple, 2);
            $estimate_price = ucwords($f->format($multiple2));
            $price_calculated = number_format((float)$multiple, 2, '.', ',');
        } else{
            $estimate_price = ucwords($f->format($AssessmentCurrvalueVehicle->estimate_price));
            $price_calculated = number_format((float)$AssessmentCurrvalueVehicle->estimate_price, 2, '.', ',');
        }
        $date = Carbon::parse($AssessmentCurrvalueVehicle->assessment_dt)->translatedFormat('d F Y');
        $checkApp = Carbon::parse($AssessmentCurrvalueVehicle->assessment_dt)->translatedFormat('d F Y');

        $module = [
            'assessment_new' => 'new',
            'assessment_currvalue' => 'currvalue',
            'assessment_accident' => 'accident',
            'assessment_gov_loan' => 'gov_loan',
            'assessment_disposal' => 'disposal',
            'assessment_safety' => 'safety'
        ];

        $params = [
            'price_calculated' => $price_calculated,
            'estimate_price' => $estimate_price,
            'asset_path' => public_path('my-assets'),
            'assessment_vehicle_currvalue_id' => $request->vehicle_id,
            // 'check_is_genuine_url' => Route('.redirect').'?redirectTo='.route('assessment.'.$module["assessment_currvalue"].'.vehicle-certificate.checkGenuine'),
            'check_is_genuine_url' => route('assessment.'.$module[$request->table_name].'.vehicle-certificate.checkGenuine'),
            'tarikh_periksa' => $checkApp,
            'woksyop_state' => $woksyop_state,
            'state_of_woksyop' => $state_of_woksyop,
            'branch_workshop_state' => $branch_workshop_state
        ];
        break;

    case 'borang_am362b':

        $AssessmentAccident = AssessmentAccidentVehicle::where('assessment_accident_id', $request->assessment_accident_id)->first();
        $f = new NumberFormatter("ms", NumberFormatter::SPELLOUT);
        $estimate_pricereformatted = ucwords($f->format($AssessmentAccident->estimate_price));

        $number_of_damages = $AssessmentAccident->hasVehicleDamageForm->count();

        $total_damages= ucwords(strtoupper($f->format($number_of_damages)));

        $params = [
            'total_damages' => $total_damages,
            'estimate_price' => $estimate_pricereformatted,
            'assessment_accident_id' => $request->assessment_accident_id,
        ];
        break;

    case 'borang_kerosakan':

        $module = [
            'assessment_new' => 'new',
            'assessment_currvalue' => 'currvalue',
            'assessment_accident' => 'accident',
            'assessment_gov_loan' => 'gov_loan',
            'assessment_disposal' => 'disposal',
            'assessment_safety' => 'safety'
        ];
        $params = [
            'accident_vehicle_id' => $request->assessment_accident_id,
            'asset_path' => public_path('my-assets'),
        ];

        break;

    case 'assessment_certificate_gov_loan':

        $AssessmentGovLoanVehicle = AssessmentGovLoanVehicle::find($request->vehicle_id);

        // $woksyop_state = str_replace($str, "", $AssessmentNew->hasWorkShop->hasState->desc);
        if($AssessmentGovLoanVehicle->hasAssessmentDetail->hasWorkShop->hasState->code == '14'){
            $woksyop_state = "BAHAGIAN PERKHIDMATAN MEKANIKAL \n CAWANGAN KEJURUTERAAN MEKANIKAL \n IBU PEJABAT JKR MALAYSIA";
            $branch_workshop_state = "BAHAGIAN PERKHIDMATAN MEKANIKAL, CAWANGAN KEJURUTERAAN MEKANIKAL, IBU PEJABAT JKR MALAYSIA";
            $state_of_woksyop = "BAHAGIAN PERKHIDMATAN MEKANIKAL CKM IP JKR";
        } else {
            $woksyop_state =  "CAWANGAN KEJURUTERAAN MEKANIKAL \n NEGERI ".$AssessmentGovLoanVehicle->hasAssessmentDetail->hasWorkShop->hasState->desc;
            $branch_workshop_state = "CAWANGAN KEJURUTERAAN MEKANIKAL <br/> NEGERI " .$AssessmentGovLoanVehicle->hasAssessmentDetail->hasWorkShop->hasState->desc;

                if(($AssessmentGovLoanVehicle->hasAssessmentDetail->hasWorkShop->hasState->code == '05') ||
                ($AssessmentGovLoanVehicle->hasAssessmentDetail->hasWorkShop->hasState->code == '15') ||
                ($AssessmentGovLoanVehicle->hasAssessmentDetail->hasWorkShop->hasState->code == '16')){
                    $state_of_woksyop = $AssessmentGovLoanVehicle->hasAssessmentDetail->hasWorkShop->hasState->desc;
                }
                else{
                    $state_of_woksyop = "NEGERI "  .$AssessmentGovLoanVehicle->hasAssessmentDetail->hasWorkShop->hasState->desc;
                }
        }

        $f = new NumberFormatter("ms", NumberFormatter::SPELLOUT);
        $estimate_price = ucwords($f->format($AssessmentGovLoanVehicle->estimate_price));

        $date = Carbon::parse($AssessmentGovLoanVehicle->assessment_dt)->translatedFormat('d F Y');
        $checkApp = Carbon::parse($AssessmentGovLoanVehicle->assessment_dt)->translatedFormat('d F Y');

        $module = [
            'assessment_new' => 'new',
            'assessment_currvalue' => 'currvalue',
            'assessment_accident' => 'accident',
            'assessment_gov_loan' => 'gov_loan',
            'assessment_disposal' => 'disposal',
            'assessment_safety' => 'safety'
        ];

        $params = [
            'estimate_price' => $estimate_price,
            'asset_path' => public_path('my-assets'),
            'assessment_vehicle_govloan_id' => $request->vehicle_id,
            // 'check_is_genuine_url' => Route('.redirect').'?redirectTo='.route('assessment.'.$module["assessment_gov_loan"].'.vehicle-certificate.checkGenuine'),
            'check_is_genuine_url' => route('assessment.'.$module[$request->table_name].'.vehicle-certificate.checkGenuine'),
            'tarikh_periksa' => $checkApp,
            'woksyop_state' => $woksyop_state,
            'state_of_woksyop' => $state_of_woksyop,
            'branch_workshop_state' => $branch_workshop_state
        ];
        break;

    case 'diposal_certificate':

        $module = [
            'assessment_new' => 'new',
            'assessment_currvalue' => 'currvalue',
            'assessment_accident' => 'accident',
            'assessment_gov_loan' => 'gov_loan',
            'assessment_disposal' => 'disposal',
            'assessment_safety' => 'safety'
        ];
        $params = [
        ];
        break;

    ////others

    case 'letter_of_guarantee':
        $params = [
            'assessment_new_id' => $request->assessment_new_id,
        ];
        break;

    case 'letter_of_release_of_dependent':
        $params = [
            'assessment_disposal_id' => $request->assessment_disposal_id,
        ];
        break;

    case 'letter_of_release_of_dependent_safety':
        $params = [
            'assessment_safety_id' => $request->assessment_safety_id,
        ];
        break;

    case 'disposal_certificate':
        $params = [
            'assessment_disposal_vehicle_id' => $request->assessment_disposal_vehicle_id,
        ];
        break;

    case 'borang_pesanan_kerja':
        $total = 0;
        // $model_name = array();
        $model_name = "";
        $jenis = "";
        $no_pendaftaran = "";
        $ptj_no = $request->ptj_no ? $request->ptj_no : "";
        $AssessmentNew = AssessmentNew::findOrFail($request->assessment_new_id);
        $dataNew = [
            'no_ptj' => $ptj_no,
        ];
        $AssessmentNew->update($dataNew);
        $AssessmentNewVehicle = AssessmentNewVehicle::where('assessment_new_id', $request->assessment_new_id)->where('price', '!=', 0)->get();
        foreach ($AssessmentNewVehicle as $list){
            $total += $list->price;
            $no_pendaftaran != "" && $no_pendaftaran .= ", ";
            $no_pendaftaran = $no_pendaftaran.$list->plate_no;
        }

        $detail = $AssessmentNewVehicle->first();
        $hasManyVeModel = $detail->hasAssessmentDetail->hasManyVehicleModelWithTotal;
        $hasManyVeType = $detail->hasAssessmentDetail->hasManyVehicleTypeWithTotal;

        foreach ($hasManyVeModel as $VeModel) {
            $model_name != "" && $model_name .= ", ";
            $model_name = $model_name.$list->hasVehicleBrand->name.' '.$VeModel->model_name.'('.$VeModel->total.')';
            $jenis = strtoupper($model_name);
        }

        foreach ($hasManyVeType as $VeType) {
            $jenis != "" && $jenis .= ", ";
            $jenis = $jenis.$VeType->hasSubCategoryType->name.'('.$VeType->total.')';
            $jenis = strtoupper($jenis);
        }

        $f = new NumberFormatter("ms", NumberFormatter::SPELLOUT);
        $total_formatted = ucwords($f->format($total));
        $params = [
            'assessment_new_id' => $request->assessment_new_id,
            'total_formatted' => $total_formatted,
            'model_name' => $model_name,
            'jenis' => $jenis,
            'no_pendaftaran' => $no_pendaftaran,
            'ptj_no' => $ptj_no
        ];
        break;

    case 'borang_pesanan_kerja_gov_loan':
        $total = 0;
        $model_name = "";
        $jenis = "";
        $no_pendaftaran = "";
        $ptj_no = $request->ptj_no ? $request->ptj_no : "";
        $AssessmentGovLoan = AssessmentGovLoan::findOrFail($request->assessment_gov_loan_id);
        $dataCurrvalue = [
            'no_ptj' => $ptj_no,
        ];
        $AssessmentGovLoan->update($dataCurrvalue);
        $AssessmentGovLoanVehicle = AssessmentGovLoanVehicle::where('assessment_gov_loan_id', $request->assessment_gov_loan_id)->where('vehicle_price', '!=', 0)->get();
        foreach ($AssessmentGovLoanVehicle as $list){
            $total += $list->price;
            $no_pendaftaran != "" && $no_pendaftaran .= ", ";
            $no_pendaftaran = $no_pendaftaran.$list->plate_no;
        }

        $detail = $AssessmentGovLoanVehicle->first();
        $hasManyVeModel = $detail->hasAssessmentDetail->hasManyVehicleModelWithTotal;
        $hasManyVeType = $detail->hasAssessmentDetail->hasManyVehicleTypeWithTotal;

        foreach ($hasManyVeModel as $VeModel) {
            $model_name != "" && $model_name .= ", ";
            $model_name = $model_name.$list->hasVehicleBrand->name.' '.$VeModel->model_name.'('.$VeModel->total.')';
            $jenis = strtoupper($model_name);
        }

        foreach ($hasManyVeType as $VeType) {
            $jenis != "" && $jenis .= ", ";
            $jenis = $jenis.$VeType->hasSubCategoryType->name.'('.$VeType->total.')';
            $jenis = strtoupper($jenis);
        }
        $f = new NumberFormatter("ms", NumberFormatter::SPELLOUT);
        $total_formatted = ucwords($f->format($total));
        $params = [
            'assessment_gov_loan_id' => $request->assessment_gov_loan_id,
            'total_formatted' => $total_formatted,
            'model_name' => $model_name,
            'jenis' => $jenis,
            'no_pendaftaran' => $no_pendaftaran,
            'ptj_no' => $ptj_no
        ];
        break;

    case 'borang_pesanan_kerja_harga_semasa':
        $total = 0;
        $model_name = "";
        $jenis = "";
        $no_pendaftaran = "";
        $ptj_no = $request->ptj_no ? $request->ptj_no : "";
        $AssessmentCurrvalue = AssessmentCurrvalue::findOrFail($request->assessment_currvalue_id);
        $dataCurrvalue = [
            'no_ptj' => $ptj_no,
        ];
        $AssessmentCurrvalue->update($dataCurrvalue);
        $AssessmentCurrvalueVehicle = AssessmentCurrvalueVehicle::where('assessment_currvalue_id', $request->assessment_currvalue_id)->where('vehicle_price', '!=', 0)->get();
        foreach ($AssessmentCurrvalueVehicle as $list){
            $total += $list->price;
            $no_pendaftaran != "" && $no_pendaftaran .= ", ";
            $no_pendaftaran = $no_pendaftaran.$list->plate_no;
        }

        $detail = $AssessmentCurrvalueVehicle->first();
        $hasManyVeModel = $detail->hasAssessmentDetail->hasManyVehicleModelWithTotal;
        $hasManyVeType = $detail->hasAssessmentDetail->hasManyVehicleTypeWithTotal;

        foreach ($hasManyVeModel as $VeModel) {
            $model_name != "" && $model_name .= ", ";
            $model_name = $model_name.$list->hasVehicleBrand->name.' '.$VeModel->model_name.'('.$VeModel->total.')';
            $jenis = strtoupper($model_name);
        }

        foreach ($hasManyVeType as $VeType) {
            $jenis != "" && $jenis .= ", ";
            $jenis = $jenis.$VeType->hasSubCategoryType->name.'('.$VeType->total.')';
            $jenis = strtoupper($jenis);
        }

        $f = new NumberFormatter("ms", NumberFormatter::SPELLOUT);
        $total_formatted = ucwords($f->format($total));

        $params = [
            'assessment_currvalue_id' => $request->assessment_currvalue_id,
            'total_formatted' => $total_formatted,
            'model_name' => $model_name,
            'jenis' => $jenis,
            'no_pendaftaran' => $no_pendaftaran,
            'ptj_no' => $ptj_no
        ];
        break;

    case 'disposal_letter2':
        // dd($request->all());
        $params = [
            // 'assessment_id' => $request->assessment_id,
            // 'letter_ref' => $request->letter_ref,
            // 'letter_date' => $request->letter_date,
            // 'up_name' => $request->up_name,
            // 'ref_number' => $request->ref_number,
            // 'evaluate_date' => $request->evaluate_date,
            // 'car_total' => $request->car_total,
            // 'no_tel' => $request->no_tel,
            // 'propaganda' => $request->propaganda,
            // 'signature_name' => $request->signature_name,
            // 'jawatan' => $request->jawatan,
            // 'woksyop_state' => $request->woksyop,
            // 'bahagian' => $request->bahagian,
            // 'state' => $request->state,
        ];
        break;

    case 'assessment_checklist':

        $checkListLvl2 = app_path().'/jasper/checklist_lvl2.jasper';
        $checkListLvl3 = app_path().'/jasper/checklist_lvl3.jasper';

        if(!file_exists($checkListLvl2)) {
            $fileCheckListLvl2 = app_path().'/jasper/checklist_lvl2.jrxml';
            $jasper->compile($fileCheckListLvl2)->execute();
        }

        if(!file_exists($checkListLvl3)) {
            $fileCheckListLvl3 = app_path().'/jasper/checklist_lvl3.jrxml';
            $jasper->compile($fileCheckListLvl3)->execute();
        }

        $assessment_type_id = $request->assessment_type_id;
        $vehicle_id = $request->vehicle_id;

        $mappingTitle = [
            '01' => 'Borang Pemeriksaan Kenderaan Baharu',
            '02' => 'Borang Pemeriksaan Keselamatan dan Prestasi',
            '03' => 'Borang Laporan Kerosakan Kemalangan',
            '04' => 'Borang Penilaian Harga Semasa Aset Terpakai',
            '05' => 'Borang Pemeriksaan Kenderaan Terpakai',
            '06' => 'Borang Pemeriksaan Dan Penilaian Aset Mekanikal Untuk Pelupusan'
        ];

        $checkForm = AssessmentFormCheckLvl1::where([
            'assessment_type_id' => $assessment_type_id,
            'vehicle_id' => $vehicle_id
        ])->first();

        $params = [
            'asset_path' => public_path('my-assets'),
            'report_title' => $mappingTitle[$checkForm->hasAssessmentType->code],
            'assessment_type_id' => $assessment_type_id,
            'vehicle_id' => $vehicle_id,
            'document_no' => $checkForm->hasAssessmentType->document_no,
            'produce_no' => $checkForm->hasAssessmentType->produce_no,
            'amendment_no' => $checkForm->hasAssessmentType->amendment_no,
            'amendment_dt' => Carbon::parse($checkForm->hasAssessmentType->amendment_dt)->translatedFormat('d/m/Y'),
            'foremen_name' => $checkForm->hasVehicle->foremenBy->name,
            'foremen_date' => Carbon::parse($checkForm->hasVehicle->forment_dt)->translatedFormat('d/m/Y'),

        ];
        break;

    case 'assessment_currvalue_checklist':

        // $assessment_currvalue_checklist_tyre = app_path().'/jasper/assessment_currvalue_checklist_tyre.jasper';

        // if(!file_exists($assessment_currvalue_checklist_tyre)) {
        //     $fileAssessment_currvalue_checklist_tyre = app_path().'/jasper/assessment_currvalue_checklist_tyre.jrxml';
        //     $jasper->compile($fileAssessment_currvalue_checklist_tyre)->execute();
        // }

        $assessment_type_id = $request->assessment_type_id;
        $vehicle_id = $request->vehicle_id;

        $mappingTitle = [
            '01' => 'Borang Pemeriksaan Kenderaan Baharu',
            '02' => 'Borang Pemeriksaan Keselamatan dan Prestasi',
            '03' => 'Borang Laporan Kerosakan Kemalangan',
            '04' => 'Borang Penilaian Harga Semasa Aset Terpakai',
            '05' => 'Borang Pemeriksaan Kenderaan Terpakai',
            '06' => 'Borang Pemeriksaan Dan Penilaian Aset Mekanikal Untuk Pelupusan'
        ];

        $hasVehicle = AssessmentCurrvalueVehicle::find($vehicle_id);

        $hasAssessmentType = AssessmentType::where('code', '04')->first();

        $params = [
            'asset_path' => public_path('my-assets'),
            'report_title' => $mappingTitle['04'],
            'assessment_type_id' => $hasAssessmentType->id,
            'vehicle_id' => $vehicle_id,
            'document_no' => $hasAssessmentType->document_no,
            'produce_no' => $hasAssessmentType->produce_no,
            'amendment_no' => $hasAssessmentType->amendment_no,
            'amendment_dt' => Carbon::parse($hasAssessmentType->amendment_dt)->translatedFormat('d/m/Y'),
            'foremen_name' => $hasVehicle->foremenBy->name,
            'foremen_date' => Carbon::parse($hasVehicle->forment_dt)->translatedFormat('d/m/Y'),
            'assisst_engineer_name' => $hasVehicle->verifyBy->name,

        ];
        break;

    case 'assessment_gov_loan_checklist':

        $assessment_type_id = $request->assessment_type_id;
        $vehicle_id = $request->vehicle_id;

        $mappingTitle = [
            '01' => 'Borang Pemeriksaan Kenderaan Baharu',
            '02' => 'Borang Pemeriksaan Keselamatan dan Prestasi',
            '03' => 'Borang Laporan Kerosakan Kemalangan',
            '04' => 'Borang Penilaian Harga Semasa Aset Terpakai',
            '05' => 'Borang Pemeriksaan Kenderaan Terpakai',
            '06' => 'Borang Pemeriksaan Dan Penilaian Aset Mekanikal Untuk Pelupusan'
        ];

        $hasVehicle = AssessmentGovLoanVehicle::find($vehicle_id);

        $hasAssessmentType = AssessmentType::where('code', '05')->first();

        $params = [
            'asset_path' => public_path('my-assets'),
            'report_title' => $mappingTitle['05'],
            'assessment_type_id' => $hasAssessmentType->id,
            'vehicle_id' => $vehicle_id,
            'document_no' => $hasAssessmentType->document_no,
            'produce_no' => $hasAssessmentType->produce_no,
            'amendment_no' => $hasAssessmentType->amendment_no,
            'amendment_dt' => Carbon::parse($hasAssessmentType->amendment_dt)->translatedFormat('d/m/Y'),
            'foremen_name' => $hasVehicle->foremenBy->name,
            'foremen_date' => Carbon::parse($hasVehicle->forment_dt)->translatedFormat('d/m/Y'),
            'assisst_engineer_name' => $hasVehicle->verifyBy->name,

        ];
        break;

    default:
        # code...
        break;
}
