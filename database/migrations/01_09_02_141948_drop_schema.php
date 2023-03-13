<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // DB::statement('DROP SCHEMA identifiers CASCADE');
        // DB::statement('CREATE SCHEMA identifiers');

        // DB::statement('DROP SCHEMA kenderaans CASCADE');
        // DB::statement('CREATE SCHEMA kenderaans');

        // DB::statement('DROP SCHEMA locations CASCADE');
        // DB::statement('CREATE SCHEMA locations');	

        // DB::statement('DROP SCHEMA "public" CASCADE');
        // DB::statement('CREATE SCHEMA "public"');

        // DB::statement('DROP SCHEMA saman CASCADE');
        // DB::statement('CREATE SCHEMA saman');

        // DB::statement('DROP SCHEMA users CASCADE');
        // DB::statement('CREATE SCHEMA users');

        // DB::statement('DROP SCHEMA vehicles CASCADE');
        // DB::statement('CREATE SCHEMA vehicles');

        // DB::statement('DROP SCHEMA fleet CASCADE');
        // DB::statement('CREATE SCHEMA fleet');

        // DB::statement('DROP SCHEMA logistic CASCADE');
        // DB::statement('CREATE SCHEMA logistic');

        // DB::statement('DROP SCHEMA maintenance CASCADE');
        // DB::statement('CREATE SCHEMA maintenance');

        // DB::statement('DROP SCHEMA assessment CASCADE');
        // DB::statement('CREATE SCHEMA assessment');

        // DB::statement('DROP SCHEMA audit CASCADE');
        // DB::statement('CREATE SCHEMA audit');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
