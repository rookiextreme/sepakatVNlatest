<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTriggerAssessmentAudit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::unprepared('
        CREATE SEQUENCE audit.audit_assessment_id_seq
        INCREMENT 1
        START 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        CACHE 1;

        create table audit.assessment_audit(
        id bigint NOT NULL DEFAULT nextval(\'audit.audit_assessment_id_seq\'::regclass),
        submodul varchar(200),
        reference varchar(50),
        audit_ts timestamptz not null default now(),
        operation varchar(10)not null,
        username text not null default "current_user"(),
        userapps text not null default "current_user"(),
        before jsonb,
        after jsonb
        );


        CREATE TRIGGER assessment_nv_audit_trig
        BEFORE UPDATE OR DELETE
        ON assessment.assessment_new_vehicle
        FOR EACH ROW
        EXECUTE PROCEDURE assessment.assessment_nv_audit_func();

        CREATE TRIGGER assessment_sv_audit_trig
        BEFORE UPDATE OR DELETE
        ON assessment.assessment_safety_vehicle
        FOR EACH ROW
        EXECUTE PROCEDURE assessment.assessment_sv_audit_func();

        CREATE TRIGGER assessment_cv_audit_trig
        BEFORE UPDATE OR DELETE
        ON assessment.assessment_currvalue_vehicle
        FOR EACH ROW
        EXECUTE PROCEDURE assessment.assessment_cv_audit_func();

        CREATE TRIGGER assessment_lv_audit_trig
        BEFORE UPDATE OR DELETE
        ON assessment.assessment_gov_loan_vehicle
        FOR EACH ROW
        EXECUTE PROCEDURE assessment.assessment_lv_audit_func();

        CREATE TRIGGER assessment_dv_audit_trig
        BEFORE UPDATE OR DELETE
        ON assessment.assessment_disposal_vehicle
        FOR EACH ROW
        EXECUTE PROCEDURE assessment.assessment_dv_audit_func();




        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        DB::unprepared('
        DROP TRIGGER `fleet_audit_trig`;
        DROP FUNCTION fleet.fleet_audit_func;
        ');
    }
}
