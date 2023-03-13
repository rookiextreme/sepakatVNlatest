<?php

namespace App\Http\Controllers\Assessment\Calendar;

use App\Http\Controllers\Helpers\HelpersFunction;
use App\Mail\module\assessment\currvalue\SendEmailToUserAssessmentCurrvalueVehicleStatus;
use App\Models\Assessment\AssessmentApplicationStatus;
use App\Models\Assessment\AssessmentCurrvalue;
use App\Models\RefWorkshop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;

class AssessmentCalendarDAO
{

    public $id = -1;
    public $detail;
    public $detailVehicle;
    public $message;
    public $url;
    public $statusCode;

    public function getAppoimentByWorkshopId($workshopId)
    {

        $assessmentType = ['new','disposal', 'gov_loan', 'safety', 'accident', 'currvalue'];

        $query = DB::select(DB::raw('
        SELECT an.ref_number AS refNumber, an.appointment_dt AS appointmentDate, an.applicant_name AS name, an.email AS email, an.phone_no AS phone,
        aas.desc AS status, aas.id AS status_id
        FROM assessment.assessment_'.$assessmentType[0].' an
        JOIN assessment.assessment_application_status aas ON an.app_status_id = aas.id
        WHERE app_status_id IN (4,5,6)
        AND workshop_id = ?

        UNION

        SELECT an.ref_number AS refNumber, an.appointment_dt AS appointmentDate, an.applicant_name AS name, an.email AS email, an.phone_no AS phone,
        aas.desc AS status, aas.id AS status_id
        FROM assessment.assessment_'.$assessmentType[1].' an
        JOIN assessment.assessment_application_status aas ON an.app_status_id = aas.id
        WHERE app_status_id IN (4,5,6)
        AND workshop_id = ?

        UNION

        SELECT an.ref_number AS refNumber, an.appointment_dt AS appointmentDate, an.applicant_name AS name, an.email AS email, an.phone_no AS phone,
        aas.desc AS status, aas.id AS status_id
        FROM assessment.assessment_'.$assessmentType[2].' an
        JOIN assessment.assessment_application_status aas ON an.app_status_id = aas.id
        WHERE app_status_id IN (4,5,6)
        AND workshop_id = ?

        UNION

        SELECT an.ref_number AS refNumber, an.appointment_dt AS appointmentDate, an.applicant_name AS name, an.email AS email, an.phone_no AS phone,
        aas.desc AS status, aas.id AS status_id
        FROM assessment.assessment_'.$assessmentType[3].' an
        JOIN assessment.assessment_application_status aas ON an.app_status_id = aas.id
        WHERE app_status_id IN (4,5,6)
        AND workshop_id = ?

        UNION

        SELECT an.ref_number AS refNumber, an.appointment_dt AS appointmentDate, an.applicant_name AS name, an.email AS email, an.phone_no AS phone,
        aas.desc AS status, aas.id AS status_id
        FROM assessment.assessment_'.$assessmentType[4].' an
        JOIN assessment.assessment_application_status aas ON an.app_status_id = aas.id
        WHERE app_status_id IN (4,5,6)
        AND workshop_id = ?

        UNION

        SELECT an.ref_number AS refNumber, an.appointment_dt AS appointmentDate, an.applicant_name AS name, an.email AS email, an.phone_no AS phone,
        aas.desc AS status, aas.id AS status_id
        FROM assessment.assessment_'.$assessmentType[5].' an
        JOIN assessment.assessment_application_status aas ON an.app_status_id = aas.id
        WHERE app_status_id IN (4,5,6)
        AND workshop_id = ?

        '),[$workshopId,$workshopId,$workshopId,$workshopId,$workshopId,$workshopId]);

        //$test = implode(" ",$query);
        //Log::info('getAppoimentByWorkshopId : '.$test);
        return $query;

    }
}
?>
