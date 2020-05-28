<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddProviderCodeToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();

        //set code unique and provider code NOT
        Schema::table('products', function (Blueprint $table) {
            $table->string('provider_code')->after('code');
        });

        //drop unnused tariff table
        Schema::table('tariffs', function (Blueprint $table) {
            $table->dropForeign('tariffs_product_id_foreign');
        });

        Schema::dropIfExists('tariffs');

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

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('provider_code');
        });

        DB::commit();
    }
}
