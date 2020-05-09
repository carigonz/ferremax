<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->unsignedBigInteger('catalog_id');
            $table->unsignedBigInteger('tariff_id');
            $table->text('description')->nullable();
            $table->unsignedInteger('stock')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tariff_id')->references('id')->on('tariffs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('catalog_id')->references('id')->on('catalogs')->onUpdate('cascade')->onDelete('cascade');
        });


        Schema::table('tariffs', function($table) {
            $table->unsignedBigInteger('product_id')->after('id');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('tariffs', function($table) {
            $table->dropForeign('tariffs_product_id_foreign');
            $table->dropColumn('product_id');
        });

        Schema::table('products', function($table) {
            $table->dropForeign('products_tariff_id_foreign');
            $table->dropForeign('products_catalog_id_foreign');
        });
        Schema::drop('products');
    }

}