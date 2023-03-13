<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFunctionLookup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('

        CREATE OR REPLACE FUNCTION fleet.lookup_vappstatus(int8)
        RETURNS text
            LANGUAGE \'sql\'
            COST 100
            VOLATILE
        AS $BODY$
        SELECT name FROM identifiers.vapp_status WHERE id = $1
        $BODY$;

        CREATE OR REPLACE FUNCTION fleet.lookup_ref_owner_type(int8)
        RETURNS text
            LANGUAGE \'sql\'
            COST 100
            VOLATILE
        AS $BODY$
        SELECT "desc_bm" FROM ref_owner_type WHERE id = $1 AND display_for = \'vehicle_register\'
        $BODY$;

        CREATE OR REPLACE FUNCTION fleet.lookup_branch_owner(int8)
        RETURNS text
            LANGUAGE \'sql\'
            COST 100
            VOLATILE
        AS $BODY$
        SELECT name FROM ref_owner WHERE id = $1
        $BODY$;

        CREATE OR REPLACE FUNCTION fleet.lookup_category(int8)
        RETURNS text
            LANGUAGE \'sql\'
            COST 100
            VOLATILE
        AS $BODY$
        SELECT name FROM ref_category WHERE id = $1
        $BODY$;

        CREATE OR REPLACE FUNCTION fleet.lookup_placement(int8)
        RETURNS text
            LANGUAGE \'sql\'
            COST 100
            VOLATILE
        AS $BODY$
        SELECT "desc" FROM fleet.fleet_placement WHERE id = $1
        $BODY$;

        CREATE OR REPLACE FUNCTION fleet.lookup_state(int8)
        RETURNS text
            LANGUAGE \'sql\'
            COST 100
            VOLATILE
        AS $BODY$
        SELECT "desc" FROM ref_state WHERE id = $1
        $BODY$;


        CREATE OR REPLACE FUNCTION fleet.lookup_subcategory(int8)
        RETURNS text
            LANGUAGE \'sql\'
            COST 100
            VOLATILE
        AS $BODY$
        SELECT name FROM ref_sub_category WHERE id = $1
        $BODY$;

        CREATE OR REPLACE FUNCTION fleet.lookup_subcategory_type(int8)
        RETURNS text
            LANGUAGE \'sql\'
            COST 100
            VOLATILE
        AS $BODY$
        SELECT name FROM ref_sub_category_type WHERE id = $1
        $BODY$;


        CREATE OR REPLACE FUNCTION fleet.lookup_vehicle_brand(int8)
        RETURNS text
            LANGUAGE \'sql\'
            COST 100
            VOLATILE
        AS $BODY$
        SELECT name FROM vehicles.brands WHERE id = $1
        $BODY$;

        CREATE OR REPLACE FUNCTION fleet.lookup_vehicle_model(int8)
        RETURNS text
            LANGUAGE \'sql\'
            COST 100
            VOLATILE
        AS $BODY$
        SELECT name FROM vehicles.vehicle_models WHERE id = $1
        $BODY$;

        CREATE OR REPLACE FUNCTION fleet.lookup_vehicle_status(int8)
        RETURNS text
            LANGUAGE \'sql\'
            COST 100
            VOLATILE
        AS $BODY$
        SELECT "desc" FROM ref_vehicle_status WHERE id = $1
        $BODY$;

        CREATE OR REPLACE FUNCTION fleet.lookup_username(int8)
        RETURNS text
            LANGUAGE \'sql\'
            COST 100
            VOLATILE
        AS $BODY$
        SELECT name FROM users.users WHERE id = $1
        $BODY$;




        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_func');
    }
}
