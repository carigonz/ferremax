<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterCatalogsTableAndDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();

        Schema::table('catalogs', function (Blueprint $table) {
            $table->string('acronym')->after('name');
        });

        Schema::rename('tariff_discounts', 'discounts');

        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::beginTransaction();

        Schema::table('catalogs', function (Blueprint $table) {
            $table->dropColumn('acronym');
        });

        Schema::rename('discounts', 'tariff_discounts');

        DB::commit();
    }
}
