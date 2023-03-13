<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTriggerFleetAudit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // ALTER SEQUENCE audit.audit_fleet_id_seq
        // OWNER TO postgres;

        DB::unprepared('
        CREATE SEQUENCE audit.audit_fleet_id_seq
        INCREMENT 1
        START 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        CACHE 1;

        create table audit.fleet_audit(
        id bigint NOT NULL DEFAULT nextval(\'audit.audit_fleet_id_seq\'::regclass),
        submodul varchar(200),
        reference varchar(50),
        audit_ts timestamptz not null default now(),
        operation varchar(10)not null,
        username text not null default "current_user"(),
        userapps text not null default "current_user"(),
        before jsonb,
        after jsonb
        );


        CREATE TRIGGER fleet_audit_trig
        BEFORE UPDATE OR DELETE
        ON fleet.fleet_department
        FOR EACH ROW
        EXECUTE PROCEDURE fleet.fleet_audit_func();


        CREATE TRIGGER fleet_audit_trig
        BEFORE UPDATE OR DELETE
        ON fleet.fleet_public
        FOR EACH ROW
        EXECUTE PROCEDURE fleet.fleet_audit_func();

        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        // DB::unprepared('
        // DROP TRIGGER fleet_audit_trig`;
        // DROP FUNCTION fleet.fleet_audit_func;
        // ');
    }
}
