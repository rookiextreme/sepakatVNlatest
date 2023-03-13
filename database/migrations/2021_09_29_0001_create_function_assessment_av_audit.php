<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateFunctionAssessmentAvAudit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::unprepared('

        CREATE OR REPLACE FUNCTION "assessment"."assessment_av_audit_func"()
        RETURNS "pg_catalog"."trigger" AS $BODY$


      DECLARE Iteration Integer = 0;

      begin


               IF TG_OP = \'INSERT\'
               THEN
               INSERT INTO audit.assessment_audit (submodul, reference, operation, after)
               VALUES (\'Kemalangan\',OLD.plate_no, TG_OP, to_json(NEW)::jsonb);
               RETURN NEW;
             ELSIF TG_OP = \'UPDATE\'
              THEN
              IF NEW != OLD THEN

              INSERT INTO audit.assessment_audit (submodul, reference, operation, before, after)
              VALUES (\'Kemalangan\',OLD.plate_no, TG_OP, to_json(
           json_build_object(
      \'no_pendaftaran\', (OLD.plate_no),
      \'no_engine\', (OLD.engine_no),
      \'no_chasis\', (OLD.chasis_no),
      \'category\', fleet.lookup_category(OLD.category_id),
      \'subcategory\', fleet.lookup_subcategory(OLD.sub_category_id),
      \'subcategorytype\', fleet.lookup_subcategory_type(OLD.sub_category_type_id),
      \'brand\', fleet.lookup_vehicle_brand(OLD.vehicle_brand_id),
      \'model\', (OLD.model_name),
      \'username\', fleet.lookup_username(OLD.updated_by)
           )
          )::jsonb, to_json(
      json_build_object(
          \'no_pendaftaran\', (NEW.plate_no),
          \'no_engine\', (NEW.engine_no),
          \'no_chasis\', (NEW.chasis_no),
          \'category\', fleet.lookup_category(NEW.category_id),
          \'subcategory\', fleet.lookup_subcategory(NEW.sub_category_id),
          \'subcategorytype\', fleet.lookup_subcategory_type(NEW.sub_category_type_id),
          \'brand\', fleet.lookup_vehicle_brand(NEW.vehicle_brand_id),
          \'model\', (NEW.model_name),
          \'username\', fleet.lookup_username(NEW.updated_by)
       )
      )::jsonb);
              END IF;
              RETURN NEW;

              ELSIF TG_OP = \'DELETE\'
              THEN
              INSERT INTO audit.assessment_audit (submodul, reference, operation, before)
              VALUES (\'Kemalangan\', OLD.plate_no, TG_OP, to_json(
                json_build_object(\'no_pendaftaran\', (OLD.plate_no),
                \'username\', fleet.lookup_username(OLD.updated_by)
                )
              )::jsonb);
              RETURN OLD;
              END IF;
              end;
              $BODY$
        LANGUAGE plpgsql VOLATILE
        COST 100


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
        // DROP TRIGGER `fleet_audit_trig`;
        // DROP FUNCTION fleet.fleet_audit_func;
        // ');
    }
}
