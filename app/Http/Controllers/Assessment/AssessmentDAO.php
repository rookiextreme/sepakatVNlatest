<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Assessment\Accident\Vehicle\AssessmentAccidentVehicleDAO;
use App\Models\Assessment\AssessmentAccident;
use App\Models\Assessment\AssessmentAccidentVehicle;
use App\Models\Assessment\AssessmentCurrvalue;
use App\Models\Assessment\AssessmentCurrvalueVehicle;
use App\Models\Assessment\AssessmentDisposal;
use App\Models\Assessment\AssessmentDisposalVehicle;
use App\Models\Assessment\AssessmentNewVehicle;
use App\Models\Assessment\AssessmentFormCheckLvl1;
use App\Models\Assessment\AssessmentFormCheckLvl1Selection;
use App\Models\Assessment\AssessmentFormCheckLvl2;
use App\Models\Assessment\AssessmentFormCheckLvl3;
use App\Models\Assessment\AssessmentGovLoan;
use App\Models\Assessment\AssessmentGovLoanVehicle;
use App\Models\Assessment\AssessmentNew;
use App\Models\Assessment\AssessmentSafety;
use App\Models\Assessment\AssessmentSafetyVehicle;
use App\Models\Assessment\AssessmentType;
use App\Models\Assessment\AssessmentVehicleStatus;
use App\Models\FleetPlacement;
use App\Models\RefAgency;
use App\Models\RefComponentChecklistLvl1;
use App\Models\RefOwner;
use App\Models\RefSelection;
use App\Models\RefState;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AssessmentDAO
{
    public $id = -1;
    public $detail;
    public $message;
    public $assessment_type_code;

    public function generateForm(Request $request)
    {
        Log::info('AssessmentDAO ::  GenerateForm');
        Log::info($request);
        $this->assessment_type_code = $request->assessment_type_code;

        $checkExistFormLvl1 = AssessmentFormCheckLvl1::where([
            'vehicle_id' => $request->vehicle_id,
            'assessment_type_id' => $this->hasAssessmentType($this->assessment_type_code)
        ])->first();
        $CheckListLvl1 = RefComponentChecklistLvl1::whereHas('hasAssessmentType', function($q){
            $q->where([
                'code' => $this->assessment_type_code,
                'status' => 1
            ]);
        })->get();

        Log::info($checkExistFormLvl1);

        if(!$checkExistFormLvl1){
            foreach ($CheckListLvl1 as $CheckList){

                $insertedFormCheckLvl1  = AssessmentFormCheckLvl1::create([
                    'assessment_type_id' => $this->hasAssessmentType($this->assessment_type_code),
                    'vehicle_id' => $request->vehicle_id,
                    'checklistlvl1_id' => $CheckList->id
                ]);

                if($CheckList->has_selection){

                    foreach ($CheckList->hasManySelection as $tableSelection) {
                        $data = [
                            'assessment_form_check_lvl1_id' => $insertedFormCheckLvl1->id,
                            'table_selection_id' => $tableSelection->id,
                            'selection_id' => RefSelection::where('code', '01')->first()->id
                        ];
                        AssessmentFormCheckLvl1Selection::create($data);
                    }
                }

                Log::info($CheckList->hasManyComponentChecklistLvl2);

                foreach ($CheckList->hasManyComponentChecklistLvl2 as $CheckListLvl2){
                    $insertedFormCheckLvl2 = AssessmentFormCheckLvl2::create([
                        'vehicle_id' => $request->vehicle_id,
                        'formchecklistlvl1_id' => $insertedFormCheckLvl1->id,
                        'checklistlvl2_id' => $CheckListLvl2->id
                    ]);

                    foreach ($CheckListLvl2->hasManyComponentChecklistLvl3 as $CheckListLvl3){
                        AssessmentFormCheckLvl3::create([
                            'vehicle_id' => $request->vehicle_id,
                            'formchecklistlvl2_id' => $insertedFormCheckLvl2->id,
                            'checklistlvl3_id' => $CheckListLvl3->id
                        ]);
                    }
                }
            }
        }

        $route = '';

        switch ($this->assessment_type_code) {
            case '01':
                $Update = ['in_assessment' => true];
                $queryVehicle = AssessmentNewVehicle::find($request->vehicle_id);
                if(auth()->user()->isForemenAssessment()){
                    $AssessmentNew = AssessmentNew::find($queryVehicle->assessment_new_id);
                    $dataNew = [
                        'ttl_appointment' => $AssessmentNew->ttl_appointment - 1,
                        'ttl_assess' => $AssessmentNew->ttl_assess + 1,
                    ];
                    $AssessmentNew->update($dataNew);
                    $Update['foremen_dt'] = Carbon::now();
                }
                $queryVehicle->update($Update);
                $route = 'assessment.new.vehicle-assessment.form';
                break;
            case '02':
                $Update = ['in_assessment' => true];
                $queryVehicle = AssessmentSafetyVehicle::find($request->vehicle_id);
                if(auth()->user()->isForemenAssessment()){
                    $AssessmentSafety = AssessmentSafety::find($queryVehicle->assessment_safety_id);
                    $datasafety = [
                        'ttl_appointment' => $AssessmentSafety->ttl_appointment - 1,
                        'ttl_assess' => $AssessmentSafety->ttl_assess + 1,
                    ];
                    $AssessmentSafety->update($datasafety);
                    $Update['foremen_dt'] = Carbon::now();
                }
                $queryVehicle->update($Update);
                $route = 'assessment.safety.vehicle-assessment.form';
                break;
            case '03':
                $Update = ['in_assessment' => true];
                $queryVehicle = AssessmentAccidentVehicle::find($request->vehicle_id);
                if(auth()->user()->isForemenAssessment()){
                    $AssessmentAccident = AssessmentAccident::find($queryVehicle->assessment_accident_id);
                    $dataNew = [
                        'ttl_appointment' => $AssessmentAccident->ttl_appointment - 1,
                        'ttl_assess' => $AssessmentAccident->ttl_assess + 1,
                    ];
                    $AssessmentAccident->update($dataNew);
                    $Update['foremen_dt'] = Carbon::now();
                }
                $queryVehicle->update($Update);
                $route = 'assessment.accident.vehicle-assessment.form';
                break;
            case '04':
                $Update = ['in_assessment' => true];
                $queryVehicle = AssessmentCurrvalueVehicle::find($request->vehicle_id);
                if(auth()->user()->isForemenAssessment()){
                    $AssessmentCurrvalue = AssessmentCurrvalue::find($queryVehicle->assessment_currvalue_id);
                    $dataNew = [
                        'ttl_appointment' => $AssessmentCurrvalue->ttl_appointment - 1,
                        'ttl_assess' => $AssessmentCurrvalue->ttl_assess + 1,
                    ];
                    $AssessmentCurrvalue->update($dataNew);
                    $Update['foremen_dt'] = Carbon::now();
                }
                $queryVehicle->update($Update);
                $route = 'assessment.currvalue.vehicle-assessment.form';
                break;
            case '05':
                $Update = ['in_assessment' => true];
                $queryVehicle = AssessmentGovLoanVehicle::find($request->vehicle_id);
                if(auth()->user()->isForemenAssessment()){
                    $AssessmentGovLoan = AssessmentGovLoan::find($queryVehicle->assessment_gov_loan_id);
                    $dataNew = [
                        'ttl_appointment' => $AssessmentGovLoan->ttl_appointment - 1,
                        'ttl_assess' => $AssessmentGovLoan->ttl_assess + 1,
                    ];
                    $AssessmentGovLoan->update($dataNew);
                    $Update['foremen_dt'] = Carbon::now();
                }
                $queryVehicle->update($Update);
                $route = 'assessment.gov_loan.vehicle-assessment.form';
                break;
            case '06':
                $Update = ['in_assessment' => true];
                $queryVehicle = AssessmentDisposalVehicle::find($request->vehicle_id);
                if(auth()->user()->isForemenAssessment()){
                    $AssessmentDisposal = AssessmentDisposal::find($queryVehicle->assessment_disposal_id);
                    $dataNew = [
                        'ttl_appointment' => $AssessmentDisposal->ttl_appointment - 1,
                        'ttl_assess' => $AssessmentDisposal->ttl_assess + 1,
                    ];
                    $AssessmentDisposal->update($dataNew);
                    $Update['foremen_dt'] = Carbon::now();
                }
                $queryVehicle->update($Update);
                $route = 'assessment.disposal.vehicle-assessment.form';
                break;
        }

        if(auth()->user()->isForemenAssessment()){
            $queryVehicle->update([
                'assessment_vehicle_status_id' => $this->hasAssessmentVehicleStatus("03"),
                'foremen_by' => Auth::user()->isForemenAssessment() ? Auth::user()->id : null
            ]);
        }

        return [
            'url' => route($route, [
                'assessment_type_id' => $this->hasAssessmentType($this->assessment_type_code),
                'assessment_id' => $queryVehicle->hasAssessmentDetail,
                'vehicle_id' => $request->vehicle_id,
                'tab' => $request->tab,
                'status_code' => $request->status_code ? $request->status_code : 'all_inprogress',
            ])
        ];
    }

    public function generateFormGovloan(Request $request)
    {
        $vehiclePrice = AssessmentGovLoanVehicle::find($request->vehicle_id);
        $data = [
            'assessment_type_id' => $this->hasAssessmentType($request->assessment_type_code),
            'vehicle_id' => $request->vehicle_id,
            'assessment_dt' => Carbon::now(),
            'assessment_by' => auth()->user()->id,
            'total_price' => $vehiclePrice->vehicle_price,

        ];
        $dataVehicle = [
            'in_assessment' => true,
        ];
        $vehiclePrice->update($dataVehicle);
        $checkExistFormLvl1 = AssessmentFormCheckLvl1::where([
            'vehicle_id' => $request->vehicle_id,
            'assessment_type_id' => $this->hasAssessmentType($request->assessment_type_code),
        ])->exists();

        if(!$checkExistFormLvl1){
            Log::info("create");
            $checkExistFormLvl1 = AssessmentFormCheckLvl1::where([
                'vehicle_id' => $request->vehicle_id,
                'assessment_type_id' => $this->hasAssessmentType($request->assessment_type_code),
            ])->first();
            $insertedFormCheckLvl1  = AssessmentFormCheckLvl1::create($data);
            $check_lvl_id = $insertedFormCheckLvl1->id;
        }else{
            $checkExistFormLvl1 = AssessmentFormCheckLvl1::where([
                'vehicle_id' => $request->vehicle_id,
                'assessment_type_id' => $this->hasAssessmentType($request->assessment_type_code),
            ])->first();
            $check_lvl_id = $checkExistFormLvl1->id;
        }

        $queryVehicle = AssessmentGovLoanVehicle::find($request->vehicle_id);
        $route = 'assessment.gov_loan.vehicle-assessment.form';

        if(auth()->user()->isForemenAssessment()){
            $queryVehicle->update([
                'assessment_vehicle_status_id' => $this->hasAssessmentVehicleStatus("03"),
                'foremen_by' => Auth::user()->isForemenAssessment() ? Auth::user()->id : null
            ]);
            $AssessmentAccident = AssessmentGovLoan::find($queryVehicle->assessment_gov_loan_id);
            $dataNew = [
                'ttl_appointment' => $AssessmentAccident->ttl_appointment - 1,
                'ttl_assess' => $AssessmentAccident->ttl_assess + 1,
            ];
            $AssessmentAccident->update($dataNew);
        }

        return [
            'url' => route($route, [
                'assessment_type_id' => $this->hasAssessmentType($request->assessment_type_code),
                'assessment_id' => $queryVehicle->assessment_gov_loan_id,
                'vehicle_id' => $request->vehicle_id,
                'tab' => $request->tab,
                'check_lvl_id' => $check_lvl_id,
            ])
        ];
    }

    public function generateFormCurrvalue(Request $request)
    {
        $vehiclePrice = AssessmentCurrvalueVehicle::find($request->vehicle_id);
        $data = [
            'assessment_type_id' => $this->hasAssessmentType($request->assessment_type_code),
            'vehicle_id' => $request->vehicle_id,
            'assessment_dt' => Carbon::now(),
            'assessment_by' => auth()->user()->id,
            'total_price' => $vehiclePrice->vehicle_price,

        ];
        $dataVehicle = [
            'in_assessment' => true,
        ];
        $vehiclePrice->update($dataVehicle);
        $checkExistFormLvl1 = AssessmentFormCheckLvl1::where([
            'vehicle_id' => $request->vehicle_id,
            'assessment_type_id' => $this->hasAssessmentType($request->assessment_type_code),
        ])->exists();

        if(!$checkExistFormLvl1){
            Log::info("create");
            $checkExistFormLvl1 = AssessmentFormCheckLvl1::where([
                'vehicle_id' => $request->vehicle_id,
                'assessment_type_id' => $this->hasAssessmentType($request->assessment_type_code),
            ])->first();
            $insertedFormCheckLvl1  = AssessmentFormCheckLvl1::create($data);
            $check_lvl_id = $insertedFormCheckLvl1->id;
        }else{
            $checkExistFormLvl1 = AssessmentFormCheckLvl1::where([
                'vehicle_id' => $request->vehicle_id,
                'assessment_type_id' => $this->hasAssessmentType($request->assessment_type_code),
            ])->first();
            $check_lvl_id = $checkExistFormLvl1->id;
        }

        $queryVehicle = AssessmentCurrvalueVehicle::find($request->vehicle_id);
        $route = 'assessment.currvalue.vehicle-assessment.form';

        if(auth()->user()->isForemenAssessment()){
            $queryVehicle->update([
                'assessment_vehicle_status_id' => $this->hasAssessmentVehicleStatus("03"),
                'foremen_by' => Auth::user()->isForemenAssessment() ? Auth::user()->id : null
            ]);
            $AssessmentCurrvalue = AssessmentCurrvalue::find($queryVehicle->assessment_currvalue_id);
            $dataNew = [
                'ttl_appointment' => $AssessmentCurrvalue->ttl_appointment - 1,
                'ttl_assess' => $AssessmentCurrvalue->ttl_assess + 1,
            ];
            $AssessmentCurrvalue->update($dataNew);
        }
        // dd($request->all());
        return [
            'url' => route($route, [
                'assessment_type_id' => $this->hasAssessmentType($request->assessment_type_code),
                'assessment_id' => $queryVehicle->assessment_currvalue_id,
                'vehicle_id' => $request->vehicle_id,
                'tab' => $request->tab,
                'check_lvl_id' => $check_lvl_id,
                'prev_page' => $request->prev_page,
                'status_code' => $request->status_code ? $request->status_code : 'all_inprogress',
            ])
        ];
    }

    private function convertDateToSQLDateTime($dateVal, $format){
        return Carbon::createFromFormat('d/m/Y', $dateVal)->format($format);
    }

    private function hasAssessmentType($code){
        $data = AssessmentType::where('code', $code)->first();
        return $data->id;
    }

    private function hasAssessmentVehicleStatus($code){
        $data = AssessmentVehicleStatus::where('code', $code)->first();
        return $data->id;
    }

    public function getCheckList(Request $request){

        $checklist = AssessmentFormCheckLvl1::where([
            'assessment_type_id' => $this->hasAssessmentType($request->assessment_type_code),
            'vehicle_id' => $request->vehicle_id
        ]);
        if($request->assessment_type_code == '01'){
            $assessmentVehicle = AssessmentNewVehicle::find($request->vehicle_id);
            $assessmentDetail = $assessmentVehicle->hasAssessmentDetail;
        }elseif($request->assessment_type_code == '02'){
            $assessmentVehicle = AssessmentSafetyVehicle::find($request->vehicle_id);
            $assessmentDetail = $assessmentVehicle->hasAssessmentDetail;
        }

        $obj = [
            'checklist' => $checklist->get(),
            'assessmentVehicle' => $assessmentVehicle,
            'assessmentDetail' => $assessmentDetail,
        ];
        // dd($checklist);
        return $obj;
    }

    public function getDisposalCheckList(Request $request){

        $checklist = AssessmentFormCheckLvl1::where([
            'assessment_type_id' => 6,
            'vehicle_id' => $request->vehicle_id
        ]);
        $disposalVehicle = AssessmentDisposalVehicle::find($request->vehicle_id);
        $disposalDetail = $disposalVehicle->hasAssessmentDetail;

        $obj = [
            'checklist' => $checklist->get(),
            'disposalVehicle' => $disposalVehicle,
            'disposalDetail' => $disposalDetail
        ];
        return $obj;
    }

    public function resetAssessment(Request $request){

        $mappingTable = [
            '01' => AssessmentNewVehicle::class,
            '02' => AssessmentSafetyVehicle::class,
            '03' => AssessmentAccidentVehicle::class,
            '04' => AssessmentCurrvalueVehicle::class,
            '05' => AssessmentGovLoanVehicle::class,
            '06' => AssessmentDisposalVehicle::class
        ];

        $data = $mappingTable[$request->code]::find($request->id);
        $data->update([
            'in_assessment' => false
        ]);

        $checklist = AssessmentFormCheckLvl1::where([
            'assessment_type_id' => $this->hasAssessmentType($request->code),
            'vehicle_id' => $data->id
        ])->get();

        foreach ($checklist as $key) {
            foreach ($key->hasFormComponentCheckListLvl2 as $key2) {
                if($key2->hasFormComponentCheckListLvl3->count() > 0){
                    foreach ($key2->hasFormComponentCheckListLvl3 as $key3) {
                        $key3->delete();
                    }
                }
                $key2->delete();
            }
            $key->delete();
        }

    }

    public function reportOverall(Request $request){

        $is_report = $request->is_report ? $request->is_report : false;;

        $limit = 5;
        $offset = $request->offset ? $request->offset : 0;
        $assessment_selected_code =  $request->assessment_type_code ? $request->assessment_type_code : null;
        $year = $request->year ? $request->year : null;
        $month = $request->month ? $request->month : null;
        $filterByYearMonth = $year.'-'.$month;
        $filterByCodeStatus = "('08')";
        $queryByYearMonth = "";
        $queryByAssessmentType = "";

        if($request->year && $request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$filterByYearMonth."-%'";
        } else if($request->year){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$year."-%'";
        } else if($request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '%-".$month."-%'";
        }

        if($assessment_selected_code){
            $queryByAssessmentType = "and g.code = '".$assessment_selected_code."'";
        }

        $sql = 'select a.id, d.desc AS workshop_name, \'Kemalangan\' AS assessment_name, g.code AS assessment_code, g.code AS assessment_type, 1 as sorting,
        COALESCE(e."name", \'-\') as v_type_name, a.model_name, a.plate_no, f."desc" AS ministry_name, b.department_name,
        b.applicant_name, b.created_at, a.foremen_dt, a.evaluation_type AS assessment_method, c.desc AS app_status
        from assessment.assessment_accident_vehicle a
        join assessment.assessment_accident b on b.id = a.assessment_accident_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'03\'
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.' '.$queryByAssessmentType.'

        UNION

        select a.id, d.desc AS workshop_name, \'Pinjaman Kerajaan\' AS assessment_name, g.code AS assessment_code, g.code AS assessment_type, 2 as sorting,
        COALESCE(e."name", \'-\') as v_type_name, a.model_name, a.plate_no, f."desc" AS ministry_name, b.department_name,
        b.applicant_name, b.created_at, a.foremen_dt, a.evaluation_type AS assessment_method, c.desc AS app_status
        from assessment.assessment_gov_loan_vehicle a
        join assessment.assessment_gov_loan b on b.id = a.assessment_gov_loan_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'05\'
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.' '.$queryByAssessmentType.'

        UNION

        select a.id, d.desc AS workshop_name, \'Kenderaan Baharu\' AS assessment_name, g.code AS assessment_code, g.code AS assessment_type, 3 as sorting,
        COALESCE(e."name", \'-\') as v_type_name, a.model_name, a.plate_no, f."desc" AS ministry_name, b.department_name,
        b.applicant_name, b.created_at, a.foremen_dt, a.evaluation_type AS assessment_method, c.desc AS app_status
        from assessment.assessment_new_vehicle a
        join assessment.assessment_new b on b.id = a.assessment_new_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'01\'
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.' '.$queryByAssessmentType.'

        UNION

        select a.id, d.desc AS workshop_name, \'Harga/Nilai Semasa\' AS assessment_name, g.code AS assessment_code, g.code AS assessment_type, 4 as sorting,
        COALESCE(e."name", \'-\') as v_type_name, a.model_name, a.plate_no, f."desc" AS ministry_name, b.department_name,
        b.applicant_name, b.created_at, a.foremen_dt, \'Manual\' AS assessment_method, c.desc AS app_status
        from assessment.assessment_currvalue_vehicle a
        join assessment.assessment_currvalue b on b.id = a.assessment_currvalue_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'04\'
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.' '.$queryByAssessmentType.'

        UNION

        select a.id, d.desc AS workshop_name, \'Pelupusan\' AS assessment_name, g.code AS assessment_code, g.code AS assessment_type, 5 as sorting,
        COALESCE(e."name", \'-\') as v_type_name, a.model_name, a.plate_no, f."desc" AS ministry_name, b.department_name,
        b.applicant_name, b.created_at, a.foremen_dt, \'Manual\' AS assessment_method, c.desc AS app_status
        from assessment.assessment_disposal_vehicle a
        join assessment.assessment_disposal b on b.id = a.assessment_disposal_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'06\'
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.' '.$queryByAssessmentType.'

        UNION

        select a.id, d.desc AS workshop_name, \'Pemeriksaan Keselamatan Dan Prestasi\' AS assessment_name, g.code AS assessment_code, g.code AS assessment_type, 6 as sorting,
        COALESCE(e."name", \'-\') as v_type_name, a.model_name, a.plate_no, f."desc" AS ministry_name, b.department_name,
        b.applicant_name, b.created_at, a.foremen_dt, \'Manual\' AS assessment_method, c.desc AS app_status
        from assessment.assessment_safety_vehicle a
        join assessment.assessment_safety b on b.id = a.assessment_safety_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'02\'
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.' '.$queryByAssessmentType.'
        order by sorting';

        $assessmentTypeList = [];
        $total = 0;

        if($is_report){
            $list = DB::select($sql);
        } else {
            $list = DB::select($sql.' offset '.$offset.' limit '.$limit);
            $total = count(DB::select($sql));
            $assessmentTypeList = AssessmentType::orderBy('code')->get();
        }

        return  [
            'assessmentTypeList' => $assessmentTypeList,
            'assessment_selected_code' => $assessment_selected_code,
            'year_selected' => $year,
            'month_selected' => $month,
            'offset' => $offset,
            'limit' => $limit,
            'list' => $list,
            'total' => $total
        ];
    }

    public function reportAgencyByMonth(Request $request){

        $is_report = $request->is_report ? $request->is_report : false;
        $year = $request->year ? $request->year : null;
        $month = $request->month ? $request->month : null;
        $filterByYearMonth = $year.'-'.$month;
        $filterByCodeStatus = "('08')";
        $queryByYearMonth = "";

        if($request->year && $request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$filterByYearMonth."-%'";
        } else if($request->year){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$year."-%'";
        } else if($request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '%-".$month."-%'";
        }

        $list = [];
        $agency_list = RefAgency::all();

        $sql = 'select f.id, f.desc, date_part(\'month\',foremen_dt) as month, \'Kemalangan\' AS assessment_name, \'03\' AS assessment_code, count(*) as total
        from assessment.assessment_accident_vehicle a
        join assessment.assessment_accident b on b.id = a.assessment_accident_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'03\'
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.'
        group by f.id, date_part(\'month\',foremen_dt)

        UNION

        select f.id, f.desc, date_part(\'month\',foremen_dt) as month, \'Pinjaman Kerajaan\' AS assessment_name, \'05\' AS assessment_code, count(*) as total
        from assessment.assessment_gov_loan_vehicle a
        join assessment.assessment_gov_loan b on b.id = a.assessment_gov_loan_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'05\'
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.'
        group by f.id, date_part(\'month\',foremen_dt)

        UNION

        select f.id, f.desc, date_part(\'month\',foremen_dt) as month, \'Kenderaan Baharu\' AS assessment_name, \'01\' AS assessment_code, count(*) as total
        from assessment.assessment_new_vehicle a
        join assessment.assessment_new b on b.id = a.assessment_new_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'01\'
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.'
        group by f.id, date_part(\'month\',foremen_dt)

        UNION

        select f.id, f.desc, date_part(\'month\',foremen_dt) as month, \'Harga/Nilai Semasa\' AS assessment_name, \'04\' AS assessment_code, count(*) as total
        from assessment.assessment_currvalue_vehicle a
        join assessment.assessment_currvalue b on b.id = a.assessment_currvalue_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'04\'
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.'
        group by f.id, date_part(\'month\',foremen_dt)

        UNION

        select f.id, f.desc, date_part(\'month\',foremen_dt) as month, \'Pelupusan\' AS assessment_name, \'06\' AS assessment_code, count(*) as total
        from assessment.assessment_disposal_vehicle a
        join assessment.assessment_disposal b on b.id = a.assessment_disposal_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'06\'
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.'
        group by f.id, date_part(\'month\',foremen_dt)

        UNION

        select f.id, f.desc , date_part(\'month\',foremen_dt) as month, \'Pemeriksaan Keselamatan Dan Prestasi\' AS assessment_name, \'02\' AS assessment_code, count(*) as total
        from assessment.assessment_safety_vehicle a
        join assessment.assessment_safety b on b.id = a.assessment_safety_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'02\'
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.'
        group by f.id, date_part(\'month\',foremen_dt)';

        Log::info($sql);

        $queryByAgencyMontly = DB::select($sql);

        foreach ($agency_list as $agency) {

            $agencyObj = [
                'id' => $agency->id,
                'name' => $agency->desc,
                'total' => 0,
                'by_month' => [
                    '1' => 0,
                    '2' => 0,
                    '3' => 0,
                    '4' => 0,
                    '5' => 0,
                    '6' => 0,
                    '7' => 0,
                    '8' => 0,
                    '9' => 0,
                    '10' => 0,
                    '11' => 0,
                    '12' => 0
                ]
            ];

            foreach ($queryByAgencyMontly as $key) {
                if($key->id == $agency->id){
                    $agencyObj['by_month'][$key->month] += $key->total;
                    $agencyObj['total'] += $key->total;
                }
            }

            array_push($list, $agencyObj);
        }

        Log::info($list);

        return [
            'year_selected' => $year,
            'list' => $list
        ];
    }

    public function reportBranchByMonth(Request $request){

        $is_report = $request->is_report ? $request->is_report : false;
        $year = $request->year ? $request->year : null;
        $month = $request->month ? $request->month : null;
        $filterByYearMonth = $year.'-'.$month;
        $filterByCodeStatus = "('08')";
        $queryByYearMonth = "";

        if($request->year && $request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$filterByYearMonth."-%'";
        } else if($request->year){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$year."-%'";
        } else if($request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '%-".$month."-%'";
        }

        $list = [];
        $state_list = RefState::orderByRaw('code=\'14\' desc, code asc')->get();

        $sql = 'select h.id, h.desc, date_part(\'month\',foremen_dt) as month, \'Kemalangan\' AS assessment_name, \'03\' AS assessment_code, count(*) as total
        from assessment.assessment_accident_vehicle a
        join assessment.assessment_accident b on b.id = a.assessment_accident_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'03\'
        join ref_state h on h.id = d.state_id
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.'
        group by h.id, date_part(\'month\',foremen_dt)

        UNION

        select h.id, h.desc, date_part(\'month\',foremen_dt) as month, \'Pinjaman Kerajaan\' AS assessment_name, \'05\' AS assessment_code, count(*) as total
        from assessment.assessment_gov_loan_vehicle a
        join assessment.assessment_gov_loan b on b.id = a.assessment_gov_loan_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'05\'
        join ref_state h on h.id = d.state_id
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.'
        group by h.id, date_part(\'month\',foremen_dt)

        UNION

        select h.id, h.desc, date_part(\'month\',foremen_dt) as month, \'Kenderaan Baharu\' AS assessment_name, \'01\' AS assessment_code, count(*) as total
        from assessment.assessment_new_vehicle a
        join assessment.assessment_new b on b.id = a.assessment_new_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'01\'
        join ref_state h on h.id = d.state_id
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.'
        group by h.id, date_part(\'month\',foremen_dt)

        UNION

        select h.id, h.desc, date_part(\'month\',foremen_dt) as month, \'Harga/Nilai Semasa\' AS assessment_name, \'04\' AS assessment_code, count(*) as total
        from assessment.assessment_currvalue_vehicle a
        join assessment.assessment_currvalue b on b.id = a.assessment_currvalue_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'04\'
        join ref_state h on h.id = d.state_id
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.'
        group by h.id, date_part(\'month\',foremen_dt)

        UNION

        select h.id, h.desc, date_part(\'month\',foremen_dt) as month, \'Pelupusan\' AS assessment_name, \'06\' AS assessment_code, count(*) as total
        from assessment.assessment_disposal_vehicle a
        join assessment.assessment_disposal b on b.id = a.assessment_disposal_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'06\'
        join ref_state h on h.id = d.state_id
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.'
        group by h.id, date_part(\'month\',foremen_dt)

        UNION

        select h.id, h.desc, date_part(\'month\',foremen_dt) as month, \'Pemeriksaan Keselamatan Dan Prestasi\' AS assessment_name, \'02\' AS assessment_code, count(*) as total
        from assessment.assessment_safety_vehicle a
        join assessment.assessment_safety b on b.id = a.assessment_safety_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'02\'
        join ref_state h on h.id = d.state_id
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.'
        group by h.id, date_part(\'month\',foremen_dt)';

        Log::info($sql);

        $queryByStateMontly = DB::select($sql);
        $by_month = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0
        ];

        foreach ($state_list as $state) {

            $stateObj = [
                'id' => $state->id,
                'name' => $state->desc,
                'total' => 0,
                'by_month' => $by_month,
                'by_assessment' => [
                    '01' => [
                        'name' => 'Penilaian Kenderaan Baharu',
                        'by_month' => $by_month
                    ],
                    '02' => [
                        'name' => 'Penilaian Prestasi Dan Keselamatan',
                        'by_month' => $by_month
                    ],
                    '03' => [
                        'name' => 'Penilaian Kemalangan',
                        'by_month' => $by_month
                    ],
                    '04' => [
                        'name' => 'Penilaian Harga Semasa',
                        'by_month' => $by_month
                    ],
                    '05' => [
                        'name' => 'Penilaian Pinjaman Kerajaan',
                        'by_month' => $by_month
                    ],
                    '06' => [
                        'name' => 'Penilaian Pelupusan',
                        'by_month' => $by_month
                    ],
                ]
            ];

            foreach ($queryByStateMontly as $key) {
                if($key->id == $state->id){

                    if(isset($stateObj['by_month'][$key->month])){
                        Log::info($key->total);
                        $stateObj['by_month'][$key->month] += $key->total;
                    }

                    if(isset($stateObj['by_assessment'][$key->assessment_code]['by_month'][$key->month])){
                        Log::info($key->total);
                        $stateObj['total'] += $key->total;
                        $stateObj['by_assessment'][$key->assessment_code]['by_month'][$key->month] += $key->total;
                    }
                }
            }

            array_push($list, $stateObj);
        }

        //Log::info($list);

        return [
            'year_selected' => $year,
            'list' => $list
        ];
    }

    public function reportBranchByYear(Request $request){

        $is_report = $request->is_report ? $request->is_report : false;
        $year = $request->year ? $request->year : null;
        $month = $request->month ? $request->month : null;
        $filterByYearMonth = $year.'-'.$month;
        $filterByCodeStatus = "('08')";
        $queryByYearMonth = "";

        if($request->year && $request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$filterByYearMonth."-%'";
        } else if($request->year){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$year."-%'";
        } else if($request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '%-".$month."-%'";
        }

        $list = [];
        $state_list = RefState::orderByRaw('code=\'14\' desc, code asc')->get();

        $sql = 'select h.id, h.desc, to_char(DATE_TRUNC(\'year\',foremen_dt), \'YYYY\') as year, \'Kemalangan\' AS assessment_name, \'03\' AS assessment_code, count(*) as total
        from assessment.assessment_accident_vehicle a
        join assessment.assessment_accident b on b.id = a.assessment_accident_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'03\'
        join ref_state h on h.id = d.state_id
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.'
        group by h.id, DATE_TRUNC(\'year\',foremen_dt)

        UNION

        select h.id, h.desc, to_char(DATE_TRUNC(\'year\',foremen_dt), \'YYYY\') as year, \'Pinjaman Kerajaan\' AS assessment_name, \'05\' AS assessment_code, count(*) as total
        from assessment.assessment_gov_loan_vehicle a
        join assessment.assessment_gov_loan b on b.id = a.assessment_gov_loan_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'05\'
        join ref_state h on h.id = d.state_id
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.'
        group by h.id, DATE_TRUNC(\'year\',foremen_dt)

        UNION

        select h.id, h.desc, to_char(DATE_TRUNC(\'year\',foremen_dt), \'YYYY\') as year, \'Kenderaan Baharu\' AS assessment_name, \'01\' AS assessment_code, count(*) as total
        from assessment.assessment_new_vehicle a
        join assessment.assessment_new b on b.id = a.assessment_new_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'01\'
        join ref_state h on h.id = d.state_id
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.'
        group by h.id, DATE_TRUNC(\'year\',foremen_dt)

        UNION

        select h.id, h.desc, to_char(DATE_TRUNC(\'year\',foremen_dt), \'YYYY\') as year, \'Harga/Nilai Semasa\' AS assessment_name, \'04\' AS assessment_code, count(*) as total
        from assessment.assessment_currvalue_vehicle a
        join assessment.assessment_currvalue b on b.id = a.assessment_currvalue_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'04\'
        join ref_state h on h.id = d.state_id
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.'
        group by h.id, DATE_TRUNC(\'year\',foremen_dt)

        UNION

        select h.id, h.desc, to_char(DATE_TRUNC(\'year\',foremen_dt), \'YYYY\') as year, \'Pelupusan\' AS assessment_name, \'06\' AS assessment_code, count(*) as total
        from assessment.assessment_disposal_vehicle a
        join assessment.assessment_disposal b on b.id = a.assessment_disposal_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'06\'
        join ref_state h on h.id = d.state_id
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.'
        group by h.id, DATE_TRUNC(\'year\',foremen_dt)

        UNION

        select h.id, h.desc, to_char(DATE_TRUNC(\'year\',foremen_dt), \'YYYY\') as year, \'Pemeriksaan Keselamatan Dan Prestasi\' AS assessment_name, \'02\' AS assessment_code, count(*) as total
        from assessment.assessment_safety_vehicle a
        join assessment.assessment_safety b on b.id = a.assessment_safety_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'02\'
        join ref_state h on h.id = d.state_id
        where c.code IN '.$filterByCodeStatus.' and foremen_dt is not null '.$queryByYearMonth.'
        group by h.id, DATE_TRUNC(\'year\',foremen_dt)';

        Log::info($sql);

        $queryByStateMontly = DB::select($sql);

        $yearBackLimit = $request->year_back_limit ? $request->year_back_limit : 3;
        $yearRange = range(date('Y') - $yearBackLimit, date('Y'));

        $by_year = [];

        foreach ($yearRange as $key) {
            $by_year[$key] = 0;
        }

        foreach ($state_list as $state) {

            $stateObj = [
                'id' => $state->id,
                'name' => $state->desc,
                'total' => 0,
                'by_year' => $by_year,
                'by_assessment' => [
                    '01' => [
                        'name' => 'Penilaian Kenderaan Baharu',
                        'by_year' => $by_year
                    ],
                    '02' => [
                        'name' => 'Penilaian Prestasi Dan Keselamatan',
                        'by_year' => $by_year
                    ],
                    '03' => [
                        'name' => 'Penilaian Kemalangan',
                        'by_year' => $by_year
                    ],
                    '04' => [
                        'name' => 'Penilaian Harga Semasa',
                        'by_year' => $by_year
                    ],
                    '05' => [
                        'name' => 'Penilaian Pinjaman Kerajaan',
                        'by_year' => $by_year
                    ],
                    '06' => [
                        'name' => 'Penilaian Pelupusan',
                        'by_year' => $by_year
                    ],
                ]
            ];

            foreach ($queryByStateMontly as $key) {
                if($key->id == $state->id){
                    Log::info($stateObj['by_year']);
                    if(isset($stateObj['by_year'][$key->year])){
                        $stateObj['by_year'][$key->year] += $key->total;
                    }

                    if(isset($stateObj['by_assessment'][$key->assessment_code]['by_year'][$key->year])){
                        $stateObj['total'] += $key->total;
                        $stateObj['by_assessment'][$key->assessment_code]['by_year'][$key->year]+= $key->total;
                    }
                }
            }

            array_push($list, $stateObj);
        }

        return [
            'year_back_limit' => $yearBackLimit,
            'year_selected' => $year,
            'list' => $list,
            'year_range' => $yearRange,
            'by_year' => $by_year
        ];
    }

    public function reportVtlCkmn(Request $request){
        $is_report = $request->is_report ? $request->is_report : false;
        $year = $request->year ? $request->year : null;
        $month = $request->month ? $request->month : null;
        $filterByYearMonth = $year.'-'.$month;
        $filterByCodeStatus = "('08')";
        $queryByYearMonth = "";

        if($request->year && $request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$filterByYearMonth."-%'";
        } else if($request->year){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$year."-%'";
        } else if($request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '%-".$month."-%'";
        }

        $list = [];
        $state_list = RefState::orderByRaw('code=\'14\' desc, code asc')->get();
        $current_year = Carbon::now()->format('Y');

        $sql = '
            (
                SELECT
                    h.ID,
                    h.DESC,
                    d.DESC AS workshop_name,
                    COUNT ( fd.* ) AS total_fleet,
                    (
                        SELECT COUNT
                        ( A.* )
                    FROM
                        assessment.assessment_safety_vehicle
                        A JOIN assessment.assessment_safety b ON b.ID = A.assessment_safety_id
                        JOIN assessment.assessment_vehicle_status C ON C.ID = A.assessment_vehicle_status_id
                        JOIN ref_workshop d ON d.ID = b.workshop_id
                        JOIN ref_state h ON h.ID = d.state_id
                        JOIN fleet.fleet_department fd ON UPPER ( TRIM ( fd.no_pendaftaran ) ) = UPPER ( TRIM ( A.plate_no ) )
                    WHERE
                        to_char(DATE_TRUNC(\'year\',foremen_dt), \'YYYY\') = \''.$current_year.'\'
                        AND d.state_id = b.state_id
                        AND C.code = \'06\'
                    ) as total_assessment
                FROM
                    assessment.assessment_safety_vehicle a
                    JOIN assessment.assessment_safety b ON b.ID = a.assessment_safety_id
                    JOIN assessment.assessment_vehicle_status C ON C.ID = a.assessment_vehicle_status_id
                    JOIN ref_workshop d ON d.ID = b.workshop_id
                    JOIN ref_state h ON h.ID = d.state_id
                    JOIN fleet.fleet_department fd ON UPPER ( TRIM ( fd.no_pendaftaran ) ) = UPPER ( TRIM ( a.plate_no ) )
                WHERE
                    to_char(DATE_TRUNC(\'year\',foremen_dt), \'YYYY\') = \''.$current_year.'\'
                    AND d.state_id = b.state_id
                GROUP BY
                    h.ID,
                    d.DESC
            )
        ';

        Log::info($sql);
        $queryByStateYear = DB::select($sql);
        Log::info("queryByStateYear ->>>>>>>>> ");
        Log::info($queryByStateYear);
        $yearBackLimit = $request->year_back_limit ? $request->year_back_limit : 1;
        $yearRange = range(date('Y') - $yearBackLimit, date('Y'));

        $by_year = [];

        foreach ($yearRange as $key) {
            $by_year[$key] = 0;
        }

        foreach ($state_list as $state) {

            $stateObj = [
                'id' => $state->id,
                'name' => $state->desc,
                'total' => 0,
                'by_year' => $by_year,
                'by_assessment' => [
                        '02' => [
                            'name' => 'Penilaian Prestasi Dan Keselamatan',
                            'by_year' => $by_year
                        ],
                    ],
            ];
            $count = 0;

            foreach ($queryByStateYear as $key) {
                $stateObj['total_fleet'] = 0;
                $stateObj['total_assessment'] = 0;
                if($key->id == $state->id){
                    $count++;
                    Log::info("count ----> ".$count);
                    Log::info("key->id ----> ".$key->id);
                    Log::info("key->total_fleet ----> ".$key->total_fleet);
                    $stateObj['total_fleet'] = $stateObj['total_fleet'] + $key->total_fleet;
                    $stateObj['total_assessment'] = $stateObj['total_assessment'] + $key->total_assessment;
                }
            }

            array_push($list, $stateObj);
        }
        // dd($list);
        return view('assessment.assessment-report-vtl-ckmn', [
                        'is_report' => $is_report,
                        'year' => $year,
                        'month' => $month,
                        'filterByYearMonth' => $filterByYearMonth,
                        'filterByCodeStatus' => $filterByCodeStatus,
                        'list' => $list,
                        'year_back_limit' => $yearBackLimit,
                        'year_range' => $yearRange,
                        'year_selected' => $year,
                        'by_year' => $by_year
                    ]);
    }

    public function reportVtlCwgn(Request $request){
        $is_report = $request->is_report ? $request->is_report : false;
        $year = $request->year ? $request->year : null;
        $month = $request->month ? $request->month : null;
        $filterByYearMonth = $year.'-'.$month;
        $filterByCodeStatus = "('06')";
        $queryByYearMonth = "";

        if($request->year && $request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$filterByYearMonth."-%'";
        } else if($request->year){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$year."-%'";
        } else if($request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '%-".$month."-%'";
        }

        $list = [];
        $refowner_list = RefOwner::whereHas('hasOwnerType', function($q){
                                $q->where('code', '01')->where('display_for', 'vehicle_register');
                            })->where('status', 1)
                            ->whereNotIn('code', ['0120','0121','0124','0126'])
                            ->orderBy('code', 'DESC')
                            ->get();

        $current_year = Carbon::now()->format('Y');

        $sql = '
            (
                SELECT
                    ro.id,
                    ro."name",
                    COUNT(a.id) AS total_vehicle_safety,
                    COUNT ( fd.* ) AS total_fleet_in_safety_assess,
                    (
                        SELECT COUNT
                        ( a.* )
                    FROM
                        assessment.assessment_safety_vehicle a
                        JOIN assessment.assessment_safety b ON b.ID = a.assessment_safety_id
                        JOIN assessment.assessment_vehicle_status C ON C.ID = a.assessment_vehicle_status_id
                        JOIN fleet.fleet_department fd ON UPPER ( TRIM ( fd.no_pendaftaran ) ) = UPPER ( TRIM ( a.plate_no ) )
                        JOIN "public".ref_owner ro ON ro.id = fd.cawangan_id
                        JOIN "public".ref_owner_type rot ON rot.id = ro.owner_type_id
                        WHERE rot.code = \'01\' AND display_for = \'vehicle_register\'
                        AND to_char(DATE_TRUNC(\'year\',foremen_dt), \'YYYY\') = \''.$current_year.'\'
                        AND c.code = \'06\'
                    ) as total_fleet_in_safety_assess_done
                FROM
                    assessment.assessment_safety_vehicle a
                    JOIN assessment.assessment_safety b ON b.ID = a.assessment_safety_id
                    JOIN assessment.assessment_vehicle_status C ON C.ID = a.assessment_vehicle_status_id
                    JOIN fleet.fleet_department fd ON UPPER ( TRIM ( fd.no_pendaftaran ) ) = UPPER ( TRIM ( a.plate_no ) )
                    JOIN "public".ref_owner ro ON ro.id = fd.cawangan_id
                    JOIN "public".ref_owner_type rot ON rot.id = ro.owner_type_id
                    WHERE rot.code = \'01\' AND display_for = \'vehicle_register\' AND ro.status=1
                    AND to_char(DATE_TRUNC(\'year\',foremen_dt), \'YYYY\') = \''.$current_year.'\'
                    AND ro.code NOT IN (\'0120\',\'0121\',\'0124\',\'0126\')
                GROUP BY
                    ro.id,
                    ro."name"
            )
        ';

        Log::info($sql);
        $queryByStateYear = DB::select($sql);
        Log::info("queryByStateYear ->>>>>>>>> ");
        Log::info($queryByStateYear);
        $yearBackLimit = $request->year_back_limit ? $request->year_back_limit : 1;
        $yearRange = range(date('Y') - $yearBackLimit, date('Y'));

        $by_year = [];

        foreach ($yearRange as $key) {
            $by_year[$key] = 0;
        }

        foreach ($refowner_list as $owner) {

            $ownerObj = [
                'id' => $owner->id,
                'name' => $owner->name,
                'total' => 0,
                'by_year' => $by_year,
                'by_assessment' => [
                        '02' => [
                            'name' => 'Penilaian Prestasi Dan Keselamatan',
                            'by_year' => $by_year
                        ],
                    ],
            ];
            $count = 0;

            foreach ($queryByStateYear as $key) {
                $ownerObj['total_fleet_in_safety_assess'] = 0;
                $ownerObj['total_fleet_in_safety_assess_done'] = 0;
                if($key->id == $owner->id){
                    $count++;
                    Log::info("count ----> ".$count);
                    Log::info("key->id ----> ".$key->id);
                    Log::info("key->total_fleet_in_safety_assess ----> ".$key->total_fleet_in_safety_assess);
                    $ownerObj['total_fleet_in_safety_assess'] = $ownerObj['total_fleet_in_safety_assess'] + $key->total_fleet_in_safety_assess;
                    $ownerObj['total_fleet_in_safety_assess_done'] = $ownerObj['total_fleet_in_safety_assess_done'] + $key->total_fleet_in_safety_assess_done;
                }
            }

            array_push($list, $ownerObj);
        }
        // dd($list);
        return view('assessment.assessment-report-vtl-cwgn', [
                        'is_report' => $is_report,
                        'year' => $year,
                        'month' => $month,
                        'filterByYearMonth' => $filterByYearMonth,
                        'filterByCodeStatus' => $filterByCodeStatus,
                        'list' => $list,
                        'year_back_limit' => $yearBackLimit,
                        'year_range' => $yearRange,
                        'year_selected' => $year,
                        'by_year' => $by_year
                    ]);
    }

    public function reportPlacementStateByAssessment(Request $request){

        $is_report = $request->is_report ? $request->is_report : false;
        $year = $request->year ? $request->year : null;
        $month = $request->month ? $request->month : null;
        $filterByYearMonth = $year.'-'.$month;
        $filterByCodeStatus = "('02','03','04','05','08')";
        $queryByYearMonth = "";
        $assessment_selected_code =  $request->assessment_type_code ? $request->assessment_type_code : null;

        $queryByAssessmentType = "";

        if($request->year && $request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$filterByYearMonth."-%'";
        } else if($request->year){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$year."-%'";
        } else if($request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '%-".$month."-%'";
        }

        if($assessment_selected_code){
            $queryByAssessmentType = "and g.code = '".$assessment_selected_code."'";
        }

        $assessment_title = "Semua Pemeriksaan";

        if($assessment_selected_code){
            $assessment_title = AssessmentType::where('code', $assessment_selected_code)->first()->desc;
            $assessment_title = "Pemeriksaan ".preg_replace('/Penilaian/', '', $assessment_title);
        }

        $list = [];
        $assessmentTypeList = AssessmentType::orderBy('code')->get();
        $total = 0;
        $sql = 'select a.id, a.plate_no, h.id, h.desc AS state_name, \'Kemalangan\' AS assessment_name, g.code AS assessment_code, g.code AS assessment_type, 1 as sorting,
        count(*) as total, (
            select count(*) from assessment.assessment_accident_vehicle aa
            join assessment.assessment_accident bb on bb.id = aa.assessment_accident_id
            join assessment.assessment_application_status cc on cc.id = bb.app_status_id
            join assessment.assessment_vehicle_status ii on ii.id = aa.assessment_vehicle_status_id
            join ref_workshop dd on dd.id = bb.workshop_id
            where cc.code IN (\'02\',\'03\',\'04\',\'05\',\'08\') and ii.code in (\'02\',\'03\',\'04\',\'05\',\'06\')
            and dd.state_id = h.id and aa.id = a.id
        ) as total_inprogress,
        (
            select count(*) from fleet.fleet_department ffd
            join fleet.fleet_placement ffp on ffp.id = ffd.placement_id
            where ffp.ref_state_id = h.id and upper(trim(replace(ffd.no_pendaftaran,\' \',\'\'))) = upper(trim(replace(a.plate_no,\' \',\'\')))
        ) as total_vehicle,
        (
            select count(*) from assessment.assessment_accident_vehicle aa
            join assessment.assessment_accident bb on bb.id = aa.assessment_accident_id
            join assessment.assessment_application_status cc on cc.id = bb.app_status_id
            join assessment.assessment_vehicle_status ii on ii.id = aa.assessment_vehicle_status_id
            join ref_workshop dd on dd.id = bb.workshop_id
            where cc.code IN (\'08\') and ii.code in (\'06\')
            and dd.state_id = h.id and aa.id = a.id
        ) as total_done
        from assessment.assessment_accident_vehicle a
        join assessment.assessment_accident b on b.id = a.assessment_accident_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'03\'
        join ref_state h on h.id = d.state_id
        join assessment.assessment_vehicle_status i on i.id = a.assessment_vehicle_status_id
        where c.code IN '.$filterByCodeStatus.' and i.code in (\'02\',\'03\',\'04\',\'05\',\'06\') '.$queryByYearMonth.' '.$queryByAssessmentType.'
        group by a.id, h.id, g.code

        UNION

        select a.id, a.plate_no, h.id, h.desc AS state_name, \'Pinjaman Kerajaan\' AS assessment_name, g.code AS assessment_code, g.code AS assessment_type, 2 as sorting,
        count(*) as total, (
            select count(*) from assessment.assessment_gov_loan_vehicle aa
            join assessment.assessment_gov_loan bb on bb.id = aa.assessment_gov_loan_id
            join assessment.assessment_application_status cc on cc.id = bb.app_status_id
            join assessment.assessment_vehicle_status ii on ii.id = aa.assessment_vehicle_status_id
            join ref_workshop dd on dd.id = bb.workshop_id
            where cc.code IN (\'02\',\'03\',\'04\',\'05\',\'08\') and ii.code in (\'02\',\'03\',\'04\',\'05\',\'06\')
            and dd.state_id = h.id and aa.id = a.id
        ) as total_inprogress,
        (
            select count(*) from fleet.fleet_department ffd
            join fleet.fleet_placement ffp on ffp.id = ffd.placement_id
            where ffp.ref_state_id = h.id and upper(trim(replace(ffd.no_pendaftaran,\' \',\'\'))) = upper(trim(replace(a.plate_no,\' \',\'\')))
        ) as total_vehicle,
        (
            select count(*) from assessment.assessment_gov_loan_vehicle aa
            join assessment.assessment_gov_loan bb on bb.id = aa.assessment_gov_loan_id
            join assessment.assessment_application_status cc on cc.id = bb.app_status_id
            join assessment.assessment_vehicle_status ii on ii.id = aa.assessment_vehicle_status_id
            join ref_workshop dd on dd.id = bb.workshop_id
            where cc.code IN (\'08\') and ii.code in (\'06\')
            and dd.state_id = h.id and aa.id = a.id
        ) as total_done
        from assessment.assessment_gov_loan_vehicle a
        join assessment.assessment_gov_loan b on b.id = a.assessment_gov_loan_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'05\'
        join ref_state h on h.id = d.state_id
        join assessment.assessment_vehicle_status i on i.id = a.assessment_vehicle_status_id
        where c.code IN '.$filterByCodeStatus.' and i.code in (\'02\',\'03\',\'04\',\'05\',\'06\') '.$queryByYearMonth.' '.$queryByAssessmentType.'
        group by a.id, h.id, g.code

        UNION

        select a.id, a.plate_no, h.id, h.desc AS state_name, \'Kenderaan Baharu\' AS assessment_name, g.code AS assessment_code, g.code AS assessment_type, 3 as sorting,
        count(*) as total, (
            select count(*) from assessment.assessment_new_vehicle aa
            join assessment.assessment_new bb on bb.id = aa.assessment_new_id
            join assessment.assessment_application_status cc on cc.id = bb.app_status_id
            join assessment.assessment_vehicle_status ii on ii.id = aa.assessment_vehicle_status_id
            join ref_workshop dd on dd.id = bb.workshop_id
            where cc.code IN (\'02\',\'03\',\'04\',\'05\',\'08\') and ii.code in (\'02\',\'03\',\'04\',\'05\',\'06\')
            and dd.state_id = h.id and aa.id = a.id
        ) as total_inprogress,
        (
            select count(*) from fleet.fleet_department ffd
            join fleet.fleet_placement ffp on ffp.id = ffd.placement_id
            where ffp.ref_state_id = h.id and upper(trim(replace(ffd.no_pendaftaran,\' \',\'\'))) = upper(trim(replace(a.plate_no,\' \',\'\')))
        ) as total_vehicle,
        (
            select count(*) from assessment.assessment_new_vehicle aa
            join assessment.assessment_new bb on bb.id = aa.assessment_new_id
            join assessment.assessment_application_status cc on cc.id = bb.app_status_id
            join assessment.assessment_vehicle_status ii on ii.id = aa.assessment_vehicle_status_id
            join ref_workshop dd on dd.id = bb.workshop_id
            where cc.code IN (\'08\') and ii.code in (\'06\')
            and dd.state_id = h.id and aa.id = a.id
        ) as total_done
        from assessment.assessment_new_vehicle a
        join assessment.assessment_new b on b.id = a.assessment_new_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'01\'
        join ref_state h on h.id = d.state_id
        join assessment.assessment_vehicle_status i on i.id = a.assessment_vehicle_status_id
        where c.code IN '.$filterByCodeStatus.' and i.code in (\'02\',\'03\',\'04\',\'05\',\'06\') '.$queryByYearMonth.' '.$queryByAssessmentType.'
        group by a.id, h.id, g.code

        UNION

        select a.id, a.plate_no, h.id, h.desc AS state_name, \'Harga/Nilai Semasa\' AS assessment_name, g.code AS assessment_code, g.code AS assessment_type, 4 as sorting,
        count(*) as total, (
            select count(*) from assessment.assessment_currvalue_vehicle aa
            join assessment.assessment_currvalue bb on bb.id = aa.assessment_currvalue_id
            join assessment.assessment_application_status cc on cc.id = bb.app_status_id
            join assessment.assessment_vehicle_status ii on ii.id = aa.assessment_vehicle_status_id
            join ref_workshop dd on dd.id = bb.workshop_id
            where cc.code IN (\'02\',\'03\',\'04\',\'05\',\'08\') and ii.code in (\'02\',\'03\',\'04\',\'05\',\'06\')
            and dd.state_id = h.id and aa.id = a.id
        ) as total_inprogress,
        (
            select count(*) from fleet.fleet_department ffd
            join fleet.fleet_placement ffp on ffp.id = ffd.placement_id
            where ffp.ref_state_id = h.id and upper(trim(replace(ffd.no_pendaftaran,\' \',\'\'))) = upper(trim(replace(a.plate_no,\' \',\'\')))
        ) as total_vehicle,
        (
            select count(*) from assessment.assessment_currvalue_vehicle aa
            join assessment.assessment_currvalue bb on bb.id = aa.assessment_currvalue_id
            join assessment.assessment_application_status cc on cc.id = bb.app_status_id
            join assessment.assessment_vehicle_status ii on ii.id = aa.assessment_vehicle_status_id
            join ref_workshop dd on dd.id = bb.workshop_id
            where cc.code IN (\'08\') and ii.code in (\'06\')
            and dd.state_id = h.id and aa.id = a.id
        ) as total_done
        from assessment.assessment_currvalue_vehicle a
        join assessment.assessment_currvalue b on b.id = a.assessment_currvalue_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'04\'
        join ref_state h on h.id = d.state_id
        join assessment.assessment_vehicle_status i on i.id = a.assessment_vehicle_status_id
        where c.code IN '.$filterByCodeStatus.' and i.code in (\'02\',\'03\',\'04\',\'05\',\'06\') '.$queryByYearMonth.' '.$queryByAssessmentType.'
        group by a.id, h.id, g.code

        UNION

        select a.id, a.plate_no, h.id, h.desc AS state_name, \'Pelupusan\' AS assessment_name, g.code AS assessment_code, g.code AS assessment_type, 5 as sorting,
        count(*) as total, (
            select count(*) from assessment.assessment_disposal_vehicle aa
            join assessment.assessment_disposal bb on bb.id = aa.assessment_disposal_id
            join assessment.assessment_application_status cc on cc.id = bb.app_status_id
            join assessment.assessment_vehicle_status ii on ii.id = aa.assessment_vehicle_status_id
            join ref_workshop dd on dd.id = bb.workshop_id
            where cc.code IN (\'02\',\'03\',\'04\',\'05\',\'08\') and ii.code in (\'02\',\'03\',\'04\',\'05\',\'06\')
            and dd.state_id = h.id and aa.id = a.id
        ) as total_inprogress,
        (
            select count(*) from fleet.fleet_department ffd
            join fleet.fleet_placement ffp on ffp.id = ffd.placement_id
            where ffp.ref_state_id = h.id and upper(trim(replace(ffd.no_pendaftaran,\' \',\'\'))) = upper(trim(replace(a.plate_no,\' \',\'\')))
        ) as total_vehicle,
        (
            select count(*) from assessment.assessment_disposal_vehicle aa
            join assessment.assessment_disposal bb on bb.id = aa.assessment_disposal_id
            join assessment.assessment_application_status cc on cc.id = bb.app_status_id
            join assessment.assessment_vehicle_status ii on ii.id = aa.assessment_vehicle_status_id
            join ref_workshop dd on dd.id = bb.workshop_id
            where cc.code IN (\'08\') and ii.code in (\'06\')
            and dd.state_id = h.id and aa.id = a.id
        ) as total_done
        from assessment.assessment_disposal_vehicle a
        join assessment.assessment_disposal b on b.id = a.assessment_disposal_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'06\'
        join ref_state h on h.id = d.state_id
        join assessment.assessment_vehicle_status i on i.id = a.assessment_vehicle_status_id
        where c.code IN '.$filterByCodeStatus.' and i.code in (\'02\',\'03\',\'04\',\'05\',\'06\') '.$queryByYearMonth.' '.$queryByAssessmentType.'
        group by a.id, h.id, g.code

        UNION

        select a.id, a.plate_no, h.id, h.desc AS state_name, \'Pemeriksaan Keselamatan Dan Prestasi\' AS assessment_name, g.code AS assessment_code, g.code AS assessment_type, 6 as sorting,
        count(*) as total, (
            select count(*) from assessment.assessment_safety_vehicle aa
            join assessment.assessment_safety bb on bb.id = aa.assessment_safety_id
            join assessment.assessment_application_status cc on cc.id = bb.app_status_id
            join assessment.assessment_vehicle_status ii on ii.id = aa.assessment_vehicle_status_id
            join ref_workshop dd on dd.id = bb.workshop_id
            where cc.code IN (\'02\',\'03\',\'04\',\'05\',\'08\') and ii.code in (\'02\',\'03\',\'04\',\'05\',\'06\')
            and dd.state_id = h.id and aa.id = a.id
        ) as total_inprogress,
        (
            select count(*) from fleet.fleet_department ffd
            join fleet.fleet_placement ffp on ffp.id = ffd.placement_id
            where ffp.ref_state_id = h.id and upper(trim(replace(ffd.no_pendaftaran,\' \',\'\'))) = upper(trim(replace(a.plate_no,\' \',\'\')))
        ) as total_vehicle,
        (
            select count(*) from assessment.assessment_safety_vehicle aa
            join assessment.assessment_safety bb on bb.id = aa.assessment_safety_id
            join assessment.assessment_application_status cc on cc.id = bb.app_status_id
            join assessment.assessment_vehicle_status ii on ii.id = aa.assessment_vehicle_status_id
            join ref_workshop dd on dd.id = bb.workshop_id
            where cc.code IN (\'08\') and ii.code in (\'06\')
            and dd.state_id = h.id and aa.id = a.id
        ) as total_done
        from assessment.assessment_safety_vehicle a
        join assessment.assessment_safety b on b.id = a.assessment_safety_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'02\'
        join ref_state h on h.id = d.state_id
        join assessment.assessment_vehicle_status i on i.id = a.assessment_vehicle_status_id
        where c.code IN '.$filterByCodeStatus.' and i.code in (\'02\',\'03\',\'04\',\'05\',\'06\') '.$queryByYearMonth.' '.$queryByAssessmentType.'
        group by a.id, h.id, g.code
        order by sorting';

        Log::info($sql);

        $queryByStateAssessment = DB::select($sql);

        $state_list = RefState::orderByRaw('code=\'14\' desc, code asc')
        ->whereNotIn('code', ['16','11','12'])
        ->get();

        $mappingState = [
            '14' => 'JKR WOKSYOP PERSEKUTUAN',
            '15' => 'WILAYAH PERSEKUTUAN LABUAN'
        ];

        foreach ($state_list as $state) {

            $stateObj = [
                'id' => $state->id,
                'name' => isset($mappingState[$state->code]) ? $mappingState[$state->code]: $state->desc,
                'total_vehicle' => 0,
                'total_done' => 0,
                'total_inprogress' => 0,
                'total_done_percent' => 0
            ];

            $total_vehicle = 0;
            $total_done = 0;
            $total_inprogress = 0;

            foreach ($queryByStateAssessment as $key) {
                if($key->id == $state->id){
                    $total_vehicle += $key->total_vehicle;
                    $total_done += $key->total_done;
                    $total_inprogress += $key->total_inprogress;
                }
            }

            $stateObj['total_vehicle'] = $total_vehicle;
            $stateObj['total_done'] = $total_done;
            $stateObj['total_inprogress'] = $total_inprogress;
            $stateObj['total_done_percent'] = $total_inprogress > 0 ? round(($total_done / $total_inprogress) * 100) : 100;


            array_push($list, $stateObj);
        }

        return [
            'assessment_title' => $assessment_title,
            'year_selected' => $year,
            'assessmentTypeList' => $assessmentTypeList,
            'assessment_selected_code' => $assessment_selected_code,
            'list' => $list,
        ];

    }

    public function reportBranchByAssessment(Request $request){

        $is_report = $request->is_report ? $request->is_report : false;
        $year = $request->year ? $request->year : null;
        $month = $request->month ? $request->month : null;
        $filterByYearMonth = $year.'-'.$month;
        $filterByCodeStatus = "('02','03','04','05','08')";
        $queryByYearMonth = "";
        $assessment_selected_code =  $request->assessment_type_code ? $request->assessment_type_code : null;

        $queryByAssessmentType = "";

        if($request->year && $request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$filterByYearMonth."-%'";
        } else if($request->year){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$year."-%'";
        } else if($request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '%-".$month."-%'";
        }

        if($assessment_selected_code){
            $queryByAssessmentType = "and g.code = '".$assessment_selected_code."'";
        }

        $assessment_title = "Semua Pemeriksaan";

        if($assessment_selected_code){
            $assessment_title = AssessmentType::where('code', $assessment_selected_code)->first()->desc;
            $assessment_title = "Pemeriksaan ".preg_replace('/Penilaian/', '', $assessment_title);
        }

        $list = [];
        $assessmentTypeList = AssessmentType::orderBy('code')->get();
        $total = 0;
        $sql = 'select h.id, h.desc AS state_name, \'Kemalangan\' AS assessment_name, g.code AS assessment_code, g.code AS assessment_type, 1 as sorting,
        count(*) as total, (
            select count(*) from assessment.assessment_accident_vehicle aa
            join assessment.assessment_accident bb on bb.id = aa.assessment_accident_id
            join assessment.assessment_application_status cc on cc.id = bb.app_status_id
            join assessment.assessment_vehicle_status ii on ii.id = aa.assessment_vehicle_status_id
            join ref_workshop dd on dd.id = bb.workshop_id
            where cc.code IN (\'02\',\'03\',\'04\',\'05\',\'08\') and ii.code in (\'02\',\'03\',\'04\',\'05\',\'06\')
            and dd.state_id = h.id
        ) as total_inprogress,
        (
            select count(*) from fleet.fleet_department ffd
            join fleet.fleet_placement ffp on ffp.id = ffd.placement_id
            where ffp.ref_state_id = h.id
        ) as total_vehicle
        from assessment.assessment_accident_vehicle a
        join assessment.assessment_accident b on b.id = a.assessment_accident_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'03\'
        join ref_state h on h.id = d.state_id
        join assessment.assessment_vehicle_status i on i.id = a.assessment_vehicle_status_id
        where c.code IN '.$filterByCodeStatus.' and i.code in (\'06\') '.$queryByYearMonth.'
        group by h.id, g.code

        UNION

        select h.id, h.desc AS state_name, \'Pinjaman Kerajaan\' AS assessment_name, g.code AS assessment_code, g.code AS assessment_type, 2 as sorting,
        count(*) as total, (
            select count(*) from assessment.assessment_gov_loan_vehicle aa
            join assessment.assessment_gov_loan bb on bb.id = aa.assessment_gov_loan_id
            join assessment.assessment_application_status cc on cc.id = bb.app_status_id
            join assessment.assessment_vehicle_status ii on ii.id = aa.assessment_vehicle_status_id
            join ref_workshop dd on dd.id = bb.workshop_id
            where cc.code IN (\'02\',\'03\',\'04\',\'05\',\'08\') and ii.code in (\'02\',\'03\',\'04\',\'05\',\'06\')
            and dd.state_id = h.id
        ) as total_inprogress,
        (
            select count(*) from fleet.fleet_department ffd
            join fleet.fleet_placement ffp on ffp.id = ffd.placement_id
            where ffp.ref_state_id = h.id
        ) as total_vehicle
        from assessment.assessment_gov_loan_vehicle a
        join assessment.assessment_gov_loan b on b.id = a.assessment_gov_loan_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'05\'
        join ref_state h on h.id = d.state_id
        join assessment.assessment_vehicle_status i on i.id = a.assessment_vehicle_status_id
        where c.code IN '.$filterByCodeStatus.' and i.code in (\'06\') '.$queryByYearMonth.'
        group by h.id, g.code

        UNION

        select h.id, h.desc AS state_name, \'Kenderaan Baharu\' AS assessment_name, g.code AS assessment_code, g.code AS assessment_type, 3 as sorting,
        count(*) as total, (
            select count(*) from assessment.assessment_new_vehicle aa
            join assessment.assessment_new bb on bb.id = aa.assessment_new_id
            join assessment.assessment_application_status cc on cc.id = bb.app_status_id
            join assessment.assessment_vehicle_status ii on ii.id = aa.assessment_vehicle_status_id
            join ref_workshop dd on dd.id = bb.workshop_id
            where cc.code IN (\'02\',\'03\',\'04\',\'05\',\'08\') and ii.code in (\'02\',\'03\',\'04\',\'05\',\'06\')
            and dd.state_id = h.id
        ) as total_inprogress,
        (
            select count(*) from fleet.fleet_department ffd
            join fleet.fleet_placement ffp on ffp.id = ffd.placement_id
            where ffp.ref_state_id = h.id
        ) as total_vehicle
        from assessment.assessment_new_vehicle a
        join assessment.assessment_new b on b.id = a.assessment_new_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'01\'
        join ref_state h on h.id = d.state_id
        join assessment.assessment_vehicle_status i on i.id = a.assessment_vehicle_status_id
        where c.code IN '.$filterByCodeStatus.' and i.code in (\'06\') '.$queryByYearMonth.'
        group by h.id, g.code

        UNION

        select h.id, h.desc AS state_name, \'Harga/Nilai Semasa\' AS assessment_name, g.code AS assessment_code, g.code AS assessment_type, 4 as sorting,
        count(*) as total, (
            select count(*) from assessment.assessment_currvalue_vehicle aa
            join assessment.assessment_currvalue bb on bb.id = aa.assessment_currvalue_id
            join assessment.assessment_application_status cc on cc.id = bb.app_status_id
            join assessment.assessment_vehicle_status ii on ii.id = aa.assessment_vehicle_status_id
            join ref_workshop dd on dd.id = bb.workshop_id
            where cc.code IN (\'02\',\'03\',\'04\',\'05\',\'08\') and ii.code in (\'02\',\'03\',\'04\',\'05\',\'06\')
            and dd.state_id = h.id
        ) as total_inprogress,
        (
            select count(*) from fleet.fleet_department ffd
            join fleet.fleet_placement ffp on ffp.id = ffd.placement_id
            where ffp.ref_state_id = h.id
        ) as total_vehicle
        from assessment.assessment_currvalue_vehicle a
        join assessment.assessment_currvalue b on b.id = a.assessment_currvalue_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'04\'
        join ref_state h on h.id = d.state_id
        join assessment.assessment_vehicle_status i on i.id = a.assessment_vehicle_status_id
        where c.code IN '.$filterByCodeStatus.' and i.code in (\'06\') '.$queryByYearMonth.'
        group by h.id, g.code

        UNION

        select h.id, h.desc AS state_name, \'Pelupusan\' AS assessment_name, g.code AS assessment_code, g.code AS assessment_type, 5 as sorting,
        count(*) as total, (
            select count(*) from assessment.assessment_disposal_vehicle aa
            join assessment.assessment_disposal bb on bb.id = aa.assessment_disposal_id
            join assessment.assessment_application_status cc on cc.id = bb.app_status_id
            join assessment.assessment_vehicle_status ii on ii.id = aa.assessment_vehicle_status_id
            join ref_workshop dd on dd.id = bb.workshop_id
            where cc.code IN (\'02\',\'03\',\'04\',\'05\',\'08\') and ii.code in (\'02\',\'03\',\'04\',\'05\',\'06\')
            and dd.state_id = h.id
        ) as total_inprogress,
        (
            select count(*) from fleet.fleet_department ffd
            join fleet.fleet_placement ffp on ffp.id = ffd.placement_id
            where ffp.ref_state_id = h.id
        ) as total_vehicle
        from assessment.assessment_disposal_vehicle a
        join assessment.assessment_disposal b on b.id = a.assessment_disposal_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'06\'
        join ref_state h on h.id = d.state_id
        join assessment.assessment_vehicle_status i on i.id = a.assessment_vehicle_status_id
        where c.code IN '.$filterByCodeStatus.' and i.code in (\'06\') '.$queryByYearMonth.'
        group by h.id, g.code

        UNION

        select h.id, h.desc AS state_name, \'Pemeriksaan Keselamatan Dan Prestasi\' AS assessment_name, g.code AS assessment_code, g.code AS assessment_type, 6 as sorting,
        count(*) as total, (
            select count(*) from assessment.assessment_safety_vehicle aa
            join assessment.assessment_safety bb on bb.id = aa.assessment_safety_id
            join assessment.assessment_application_status cc on cc.id = bb.app_status_id
            join assessment.assessment_vehicle_status ii on ii.id = aa.assessment_vehicle_status_id
            join ref_workshop dd on dd.id = bb.workshop_id
            where cc.code IN (\'02\',\'03\',\'04\',\'05\',\'08\') and ii.code in (\'02\',\'03\',\'04\',\'05\',\'06\')
            and dd.state_id = h.id
        ) as total_inprogress,
        (
            select count(*) from fleet.fleet_department ffd
            join fleet.fleet_placement ffp on ffp.id = ffd.placement_id
            where ffp.ref_state_id = h.id
        ) as total_vehicle
        from assessment.assessment_safety_vehicle a
        join assessment.assessment_safety b on b.id = a.assessment_safety_id
        join assessment.assessment_application_status c on c.id = b.app_status_id
        join ref_workshop d on d.id = b.workshop_id
        left join ref_sub_category_type e on e.id = a.sub_category_type_id
        left join ref_agency f on f.id = b.agency_id
        join assessment.assessment_type g on g.code = \'02\'
        join ref_state h on h.id = d.state_id
        join assessment.assessment_vehicle_status i on i.id = a.assessment_vehicle_status_id
        where c.code IN '.$filterByCodeStatus.' and i.code in (\'06\') '.$queryByYearMonth.'
        group by h.id, g.code
        order by sorting';

        Log::info($sql);

        $queryByStateAssessment = DB::select($sql);

        $branch_list = RefOwner::whereHas('hasOwnerType', function($q){
            $q->whereIn('code', ['01'])
            ->where('display_for', 'vehicle_register');
        })->whereNotIn('code', ['0120','0121','0124','0126'])
        ->orderByRaw('code=\'0125\' desc, code asc')->get();

        $mappingState = [
            '14' => 'JKR WOKSYOP PERSEKUTUAN',
            '15' => 'WILAYAH PERSEKUTUAN LABUAN'
        ];

        $table = null;

        switch ($assessment_selected_code) {
            case '01':
                $table = AssessmentNewVehicle::class;
                break;
            case '02':
                $table = AssessmentSafetyVehicle::class;
                break;
            case '03':
                $table = AssessmentAccidentVehicle::class;
                break;
            case '04':
                $table = AssessmentCurrvalueVehicle::class;
                break;
            case '05':
                $table = AssessmentGovLoanVehicle::class;
                break;
            case '06':
                $table = AssessmentDisposalVehicle::class;
                break;

            default:
                # code...
                break;
        }

        foreach ($branch_list as $state) {

            $stateObj = [
                'id' => $state->id,
                'name' => isset($mappingState[$state->code]) ? $mappingState[$state->code]: $state->name,
                'total_vehicle' => 0,
                'total_done' => 0,
                'total_inprogress' => 0,
                'total_done_percent' => 0
            ];

            if($table){

                $total_vehicle = 0;

                $qtotal = $table::whereHas('hasAssessmentDetail', function($q) use($state){
                    $q->whereHas('hasStatus', function($q){
                        $q->whereIn('code', ['02','03','04','05','08']);
                    })->whereHas('hasWorkshop', function($q) use($state){
                        $q->where('state_id', $state->id);
                    });
                });

                $qtotal_percent = $table::whereHas('hasAssessmentDetail', function($q) use($state){
                    $q->whereHas('hasStatus', function($q){
                        $q->whereIn('code', ['02','03','04','05','08']);
                    })->whereHas('hasWorkshop', function($q) use($state){
                        $q->where('state_id', $state->id);
                    });
                });

                $total_done = $qtotal->whereHas('hasAssessmentVehicleStatus', function($q){
                    $q->where('code', '06');
                })->count();

                $total_inprogress = $qtotal_percent->whereHas('hasAssessmentVehicleStatus', function($q){
                    $q->whereIn('code', ['01','02','03','04','05']);
                })->count();
            } else {
                $total_vehicle = 0;
                $total_done = 0;
                $total_inprogress = 0;

                foreach ($queryByStateAssessment as $key) {
                    if($key->id == $state->id){
                        $total_vehicle += $key->total_vehicle;
                        $total_done += $key->total;
                        $total_inprogress += $key->total_inprogress;
                    }
                }
            }

            $stateObj['total_vehicle'] = $total_vehicle;
            $stateObj['total_done'] = $total_done;
            $stateObj['total_inprogress'] = $total_inprogress;
            $stateObj['total_done_percent'] = $total_inprogress > 0 ? round(($total_done / $total_inprogress) * 100) : 100;


            array_push($list, $stateObj);
        }

        return [
            'assessment_title' => $assessment_title,
            'year_selected' => $year,
            'assessmentTypeList' => $assessmentTypeList,
            'assessment_selected_code' => $assessment_selected_code,
            'list' => $list,
        ];

    }

    public function getVehicleDetail(Request $request){

        $assessment_type_id = $request->assessment_type_id;
        $vehicle_id = $request->vehicle_id;

        $assessmentType = AssessmentType::find($assessment_type_id);

        switch ($assessmentType->code) {
            case '01':
                $table = AssessmentNewVehicle::class;
                break;
            case '02':
                $table = AssessmentSafetyVehicle::class;
                break;
            case '03':
                $table = AssessmentAccidentVehicle::class;
                break;
            case '04':
                $table = AssessmentCurrvalueVehicle::class;
                break;
            case '05':
                $table = AssessmentGovLoanVehicle::class;
                break;
            case '06':
                $table = AssessmentDisposalVehicle::class;
                break;
        }

        $data = $table::find($vehicle_id);

        $array = [
            'id' => $data->id,
            'assessment_new_id' => $data->hasAssessmentDetail->id,
            'category_id' => $data->category_id ? $data->category_id : '-',
            'category_name' => $data->hasCategory ? $data->hasCategory->name : '-',
            'sub_category_id' => $data->sub_category_id ? $data->sub_category_id : '-',
            'subCat_name' => $data->hasSubcategory ? $data->hasSubcategory->name : '-',
            'sub_category_type_id' => $data->sub_category_type_id ? $data->sub_category_type_id : '-',
            'subCatTy_name' => $data->hasSubCategoryType ? $data->hasSubCategoryType->name : '-',
            'vehicle_brand_id' => $data->vehicle_brand_id ? $data->vehicle_brand_id : '-',
            'purchase_dt' => $data->purchase_dt ? $data->purchase_dt : null,
            'company_name' => $data->company_name ? $data->company_name : '-',
            'lo_no' => $data->lo_no ? $data->lo_no : '-',
            'is_gover' => $data->is_gover,
            'plate_no' => $data->plate_no ? $data->plate_no : '-',
            'engine_no' => $data->engine_no ? $data->engine_no : '-',
            'chasis_no' => $data->chasis_no ? $data->chasis_no : '-',
            'brand_id' => $data->vehicle_brand_id ? $data->vehicle_brand_id : '-',
            'brand_name' => $data->hasVehicleBrand ? $data->hasVehicleBrand->name : '-',
            'model_name' => $data->model_name ? $data->model_name : '-',
            'manufacture_year' => $data->manufacture_year ? $data->manufacture_year : '-',
            'registration_vehicle_dt' => $data->registration_vehicle_dt ? $data->registration_vehicle_dt : null,
            'odometer' => $data->odometer ? $data->odometer : '-',
            'hod_title' => $data->hasAssessmentDetail->hod_title ? $data->hasAssessmentDetail->hod_title : '-',
            'department_name' => $data->hasAssessmentDetail->department_name ? $data->hasAssessmentDetail->department_name : '-',
            'reason_changed' => $data->reason_changed
        ];
        return json_encode($array);
    }

    public function editVehicleSave(Request $request){

        $assessment_type_id = $request->assessment_type_id;
        $vehicle_id = $request->vehicle_id;

        $assessmentType = AssessmentType::find($assessment_type_id);
        $dataAssessment = [];

        switch ($assessmentType->code) {
            case '01':
                $table = AssessmentNewVehicle::class;
                $dataAssessment = [
                    "hod_title" => $request->ketua_jabatan,
                    "department_name" => $request->jabatan_agensi,
                ];
                break;
            case '02':
                $table = AssessmentSafetyVehicle::class;
                break;
            case '03':
                $table = AssessmentAccidentVehicle::class;
                break;
            case '04':
                $table = AssessmentCurrvalueVehicle::class;
                break;
            case '05':
                $table = AssessmentGovLoanVehicle::class;
                break;
            case '06':
                $table = AssessmentDisposalVehicle::class;
                break;
        }

        $data = $table::find($vehicle_id);

        $dataVehicle = [
            "plate_no" => $request->plate_no,
            "engine_no" => $request->engine_no,
            "chasis_no" => $request->chasis_no,
            "vehicle_brand_id" => $request->vehicle_brand_id,
            "model_name" => $request->model_name,
            "category_id" => $request->category_id,
            "sub_category_id" => $request->sub_category_id,
            "sub_category_type_id" => $request->sub_category_type_id,
            "odometer" => $request->odometer,
            "reason_changed" => $request->reason_changed,
        ];

        $data->timestamps = false;

        $queryVehicle = $data->update($dataVehicle);
        Log::info($data->hasAssessmentDetail);
        $queryAppl = $data->hasAssessmentDetail->update($dataAssessment);

        if($queryVehicle || $queryAppl){
            $message = "Maklumat Berjaya Dikemaskini";
        }

        $response = [
            'code' => 200,
            'message' =>  $message,
        ];

        Log::info($response);
        unset($response['query']);
        return $response;
    }

    public function reportVtlCkmnExcel(Request $request){
        $is_report = $request->is_report ? $request->is_report : false;
        $year = $request->year ? $request->year : null;
        $month = $request->month ? $request->month : null;
        $filterByYearMonth = $year.'-'.$month;
        $filterByCodeStatus = "('08')";
        $queryByYearMonth = "";

        if($request->year && $request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$filterByYearMonth."-%'";
        } else if($request->year){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$year."-%'";
        } else if($request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '%-".$month."-%'";
        }

        $list = [];
        $state_list = RefState::orderByRaw('code=\'14\' desc, code asc')->get();
        $current_year = Carbon::now()->format('Y');

        $sql = '
            (
                SELECT
                    h.ID,
                    h.DESC,
                    d.DESC AS workshop_name,
                    COUNT ( fd.* ) AS total_fleet,
                    (
                        SELECT COUNT
                        ( A.* )
                    FROM
                        assessment.assessment_safety_vehicle
                        A JOIN assessment.assessment_safety b ON b.ID = A.assessment_safety_id
                        JOIN assessment.assessment_vehicle_status C ON C.ID = A.assessment_vehicle_status_id
                        JOIN ref_workshop d ON d.ID = b.workshop_id
                        JOIN ref_state h ON h.ID = d.state_id
                        JOIN fleet.fleet_department fd ON UPPER ( TRIM ( fd.no_pendaftaran ) ) = UPPER ( TRIM ( A.plate_no ) )
                    WHERE
                        to_char(DATE_TRUNC(\'year\',foremen_dt), \'YYYY\') = \''.$current_year.'\'
                        AND d.state_id = b.state_id
                        AND C.code = \'06\'
                    ) as total_assessment
                FROM
                    assessment.assessment_safety_vehicle a
                    JOIN assessment.assessment_safety b ON b.ID = a.assessment_safety_id
                    JOIN assessment.assessment_vehicle_status C ON C.ID = a.assessment_vehicle_status_id
                    JOIN ref_workshop d ON d.ID = b.workshop_id
                    JOIN ref_state h ON h.ID = d.state_id
                    JOIN fleet.fleet_department fd ON UPPER ( TRIM ( fd.no_pendaftaran ) ) = UPPER ( TRIM ( a.plate_no ) )
                WHERE
                    to_char(DATE_TRUNC(\'year\',foremen_dt), \'YYYY\') = \''.$current_year.'\'
                    AND d.state_id = b.state_id
                GROUP BY
                    h.ID,
                    d.DESC
            )
        ';

        Log::info($sql);
        $queryByStateYear = DB::select($sql);
        Log::info("queryByStateYear ->>>>>>>>> ");
        Log::info($queryByStateYear);
        $yearBackLimit = $request->year_back_limit ? $request->year_back_limit : 1;
        $yearRange = range(date('Y') - $yearBackLimit, date('Y'));

        $by_year = [];

        foreach ($yearRange as $key) {
            $by_year[$key] = 0;
        }

        foreach ($state_list as $state) {

            $stateObj = [
                'id' => $state->id,
                'name' => $state->desc,
                'total' => 0,
                'by_year' => $by_year,
                'by_assessment' => [
                        '02' => [
                            'name' => 'Penilaian Prestasi Dan Keselamatan',
                            'by_year' => $by_year
                        ],
                    ],
            ];
            $count = 0;

            foreach ($queryByStateYear as $key) {
                $stateObj['total_fleet'] = 0;
                $stateObj['total_assessment'] = 0;
                if($key->id == $state->id){
                    $count++;
                    Log::info("count ----> ".$count);
                    Log::info("key->id ----> ".$key->id);
                    Log::info("key->total_fleet ----> ".$key->total_fleet);
                    $stateObj['total_fleet'] = $stateObj['total_fleet'] + $key->total_fleet;
                    $stateObj['total_assessment'] = $stateObj['total_assessment'] + $key->total_assessment;
                }
            }

            array_push($list, $stateObj);
        }
        // dd($list);
        return [
                    'is_report' => $is_report,
                    'year' => $year,
                    'month' => $month,
                    'filterByYearMonth' => $filterByYearMonth,
                    'filterByCodeStatus' => $filterByCodeStatus,
                    'list' => $list,
                    'year_back_limit' => $yearBackLimit,
                    'year_range' => $yearRange,
                    'year_selected' => $year,
                    'by_year' => $by_year
                ];
    }

    public function reportVtlCgwnExcel(Request $request){
        $is_report = $request->is_report ? $request->is_report : false;
        $year = $request->year ? $request->year : null;
        $month = $request->month ? $request->month : null;
        $filterByYearMonth = $year.'-'.$month;
        $filterByCodeStatus = "('06')";
        $queryByYearMonth = "";

        if($request->year && $request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$filterByYearMonth."-%'";
        } else if($request->year){
            $queryByYearMonth = "and foremen_dt::text LIKE '".$year."-%'";
        } else if($request->month){
            $queryByYearMonth = "and foremen_dt::text LIKE '%-".$month."-%'";
        }

        $list = [];
        $refowner_list = RefOwner::whereHas('hasOwnerType', function($q){
                                $q->where('code', '01')->where('display_for', 'vehicle_register');
                            })->where('status', 1)
                            ->whereNotIn('code', ['0120','0121','0124','0126'])
                            ->orderBy('code', 'DESC')
                            ->get();

        $current_year = Carbon::now()->format('Y');

        $sql = '
            (
                SELECT
                    ro.id,
                    ro."name",
                    COUNT(a.id) AS total_vehicle_safety,
                    COUNT ( fd.* ) AS total_fleet_in_safety_assess,
                    (
                        SELECT COUNT
                        ( a.* )
                    FROM
                        assessment.assessment_safety_vehicle a
                        JOIN assessment.assessment_safety b ON b.ID = a.assessment_safety_id
                        JOIN assessment.assessment_vehicle_status C ON C.ID = a.assessment_vehicle_status_id
                        JOIN fleet.fleet_department fd ON UPPER ( TRIM ( fd.no_pendaftaran ) ) = UPPER ( TRIM ( a.plate_no ) )
                        JOIN "public".ref_owner ro ON ro.id = fd.cawangan_id
                        JOIN "public".ref_owner_type rot ON rot.id = ro.owner_type_id
                        WHERE rot.code = \'01\' AND display_for = \'vehicle_register\'
                        AND to_char(DATE_TRUNC(\'year\',foremen_dt), \'YYYY\') = \''.$current_year.'\'
                        AND c.code = \'06\'
                    ) as total_fleet_in_safety_assess_done
                FROM
                    assessment.assessment_safety_vehicle a
                    JOIN assessment.assessment_safety b ON b.ID = a.assessment_safety_id
                    JOIN assessment.assessment_vehicle_status C ON C.ID = a.assessment_vehicle_status_id
                    JOIN fleet.fleet_department fd ON UPPER ( TRIM ( fd.no_pendaftaran ) ) = UPPER ( TRIM ( a.plate_no ) )
                    JOIN "public".ref_owner ro ON ro.id = fd.cawangan_id
                    JOIN "public".ref_owner_type rot ON rot.id = ro.owner_type_id
                    WHERE rot.code = \'01\' AND display_for = \'vehicle_register\' AND ro.status=1
                    AND to_char(DATE_TRUNC(\'year\',foremen_dt), \'YYYY\') = \''.$current_year.'\'
                    AND ro.code NOT IN (\'0120\',\'0121\',\'0124\',\'0126\')
                GROUP BY
                    ro.id,
                    ro."name"
            )
        ';

        Log::info($sql);
        $queryByStateYear = DB::select($sql);
        Log::info("queryByStateYear ->>>>>>>>> ");
        Log::info($queryByStateYear);
        $yearBackLimit = $request->year_back_limit ? $request->year_back_limit : 1;
        $yearRange = range(date('Y') - $yearBackLimit, date('Y'));

        $by_year = [];

        foreach ($yearRange as $key) {
            $by_year[$key] = 0;
        }

        foreach ($refowner_list as $owner) {

            $ownerObj = [
                'id' => $owner->id,
                'name' => $owner->name,
                'total' => 0,
                'by_year' => $by_year,
                'by_assessment' => [
                        '02' => [
                            'name' => 'Penilaian Prestasi Dan Keselamatan',
                            'by_year' => $by_year
                        ],
                    ],
            ];
            $count = 0;

            foreach ($queryByStateYear as $key) {
                $ownerObj['total_fleet_in_safety_assess'] = 0;
                $ownerObj['total_fleet_in_safety_assess_done'] = 0;
                if($key->id == $owner->id){
                    $count++;
                    Log::info("count ----> ".$count);
                    Log::info("key->id ----> ".$key->id);
                    Log::info("key->total_fleet_in_safety_assess ----> ".$key->total_fleet_in_safety_assess);
                    $ownerObj['total_fleet_in_safety_assess'] = $ownerObj['total_fleet_in_safety_assess'] + $key->total_fleet_in_safety_assess;
                    $ownerObj['total_fleet_in_safety_assess_done'] = $ownerObj['total_fleet_in_safety_assess_done'] + $key->total_fleet_in_safety_assess_done;
                }
            }

            array_push($list, $ownerObj);
        }
        // dd($list);
        return [
                    'is_report' => $is_report,
                    'year' => $year,
                    'month' => $month,
                    'filterByYearMonth' => $filterByYearMonth,
                    'filterByCodeStatus' => $filterByCodeStatus,
                    'list' => $list,
                    'year_back_limit' => $yearBackLimit,
                    'year_range' => $yearRange,
                    'year_selected' => $year,
                    'by_year' => $by_year
                ];
    }

}
