<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTriggerFleetEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::unprepared('
        CREATE OR REPLACE FUNCTION fleet.fleet_department_insert_event()
        RETURNS trigger AS $$
        BEGIN
            INSERT INTO fleet.fleet_event_history (vehicle_id, event_id, event_dt) VALUES (NEW.id, 1, NEW.created_at);
            RETURN NULL;
        END
        $$ LANGUAGE plpgsql;

        CREATE TRIGGER fleet_department_trigger
        AFTER INSERT ON fleet.fleet_department
        FOR EACH ROW
        EXECUTE PROCEDURE fleet.fleet_department_insert_event()
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
        // DROP TRIGGER fleet_department_trigger;
        // DROP FUNCTION fleet.fleet_department_insert_event;
        // ');
    }

}
