<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->boolean('status')->after('description')->default(0);
        });

        Schema::table('tariff_discounts', function (Blueprint $table) {
            $table->boolean('active')->after('amount')->default(0);
        });

        //custom field for products
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_tariff_id_foreign');
            $table->dropColumn('tariff_id');
            $table->boolean('custom')->after('name')->default(0);
            $table->unsignedDecimal('amount', 5, 3)->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('tariff_discounts', function (Blueprint $table) {
            $table->dropColumn('active');
        });

        //custom field for products
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('tariff_id');
            $table->foreign('tariff_id')->references('id')->on('tariffs')->onUpdate('cascade')->onDelete('cascade');
            $table->dropColumn('custom');
            $table->dropColumn('amount');
        });
    }
}
