<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateFunctionFleetAudit extends Migration
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

        CREATE OR REPLACE FUNCTION "fleet"."fleet_audit_func"()
        RETURNS "pg_catalog"."trigger" AS $BODY$


      DECLARE Iteration Integer = 0;

      begin


               IF TG_OP = \'INSERT\'
               THEN
               INSERT INTO audit.fleet_audit (submodul, reference, operation, after)
               VALUES (\'Rekod Kenderaan\', TG_OP, to_json(NEW)::jsonb);
               RETURN NEW;
             ELSIF TG_OP = \'UPDATE\'
              THEN
              IF NEW != OLD THEN

              INSERT INTO audit.fleet_audit (submodul, reference, operation, before, after)
              VALUES (\'Rekod Kenderaan\', OLD.no_pendaftaran, TG_OP, to_json(
           json_build_object(
      \'no_pendaftaran\', (OLD.no_pendaftaran),
      \'owner_type\', fleet.lookup_ref_owner_type(OLD.owner_type_id),
      \'no_jkr\', (OLD.no_jkr),
      \'no_engine\', (OLD.no_engine),
      \'no_chasis\', (OLD.no_chasis),
      \'vehiclestatus\', fleet.lookup_vehicle_status(OLD.vehicle_status_id),
      \'placement\', fleet.lookup_placement(OLD.placement_id),
      \'state\', fleet.lookup_state(OLD.state_id),
      \'owner_branch\', fleet.lookup_branch_owner(OLD.cawangan_id),
      \'category\', fleet.lookup_category(OLD.category_id),
      \'subcategory\', fleet.lookup_subcategory(OLD.sub_category_id),
      \'subcategorytype\', fleet.lookup_subcategory_type(OLD.sub_category_type_id),
      \'brand\', fleet.lookup_vehicle_brand(OLD.brand_id),
      \'model\', fleet.lookup_vehicle_model(OLD.model_id),
      \'username\', fleet.lookup_username(OLD.updated_by),
      \'vapp_status\', (OLD.vapp_status_id)
           )
          )::jsonb, to_json(
      json_build_object(
          \'no_pendaftaran\', (NEW.no_pendaftaran),
          \'owner_type\', fleet.lookup_ref_owner_type(NEW.owner_type_id),
          \'no_jkr\', (NEW.no_jkr),
          \'no_engine\', (NEW.no_engine),
          \'no_chasis\', (NEW.no_chasis),
          \'vehiclestatus\', fleet.lookup_vehicle_status(NEW.vehicle_status_id),
          \'placement\', fleet.lookup_placement(NEW.placement_id),
          \'state\', fleet.lookup_state(NEW.state_id),
          \'owner_branch\', fleet.lookup_branch_owner(NEW.cawangan_id),
          \'category\', fleet.lookup_category(NEW.category_id),
          \'subcategory\', fleet.lookup_subcategory(NEW.sub_category_id),
          \'subcategorytype\', fleet.lookup_subcategory_type(NEW.sub_category_type_id),
          \'brand\', fleet.lookup_vehicle_brand(NEW.brand_id),
          \'model\', fleet.lookup_vehicle_model(NEW.model_id),
          \'username\', fleet.lookup_username(NEW.updated_by),
          \'vapp_status\', (NEW.vapp_status_id)
       )
      )::jsonb);
              END IF;
              RETURN NEW;

              ELSIF TG_OP = \'DELETE\'
              THEN
              INSERT INTO audit.fleet_audit (submodul, reference, operation, before)
              VALUES (TG_OP, OLD.no_pendaftaran, to_json(
                json_build_object(\'Rekod Kenderaan\',\'no_pendaftaran\', (OLD.no_pendaftaran),
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
