<?php

namespace App\Http\Controllers\Maintenance\Calendar;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MaintenanceCalendarDAO
{

    public function getAppointmentByWorkshopId($workshopId)
    {

        $query = DB::select(DB::raw('
        SELECT me.ref_number AS refNumber, me.appointment_dt AS appointmentDate, me.applicant_name AS name, me.email AS email, me.phone_no AS phone,
        aas.desc AS status, aas.id AS status_id
        FROM maintenance.evaluation me
        JOIN maintenance.application_status aas ON me.app_status_id = aas.id
        WHERE app_status_id IN (4,5,6)
        AND workshop_id = ?

        UNION

        SELECT mj.ref_number AS refNumber, mj.appointment_dt AS appointmentDate, mj.applicant_name AS name, mj.email AS email, mj.phone_no AS phone,
        aas.desc AS status, aas.id AS status_id
        FROM maintenance.job mj
        JOIN maintenance.application_status aas ON mj.app_status_id = aas.id
        WHERE app_status_id IN (4,5,6)
        AND workshop_id = ?


        '),[$workshopId,$workshopId]);

        return $query;
    }
}
?>
