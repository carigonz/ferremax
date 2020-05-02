<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasificationsAndSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->timestamps();
        });

        Schema::create('sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('categories', function($table) {
            $table->unsignedBigInteger('classification_id')->after('id');
            $table->foreign('classification_id')->references('id')->on('classifications')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('products', function($table) {
            $table->unsignedBigInteger('section_id')->after('tariff_id')->nullable();
            $table->foreign('section_id')->references('id')->on('sections')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sections', function($table) {
            $table->dropForeign('sections_category_id_foreign');
        });

        Schema::table('categories', function($table) {
            $table->dropForeign('categories_classification_id_foreign');
            $table->dropColumn('classification_id');
        });

        Schema::table('products', function($table) {
            $table->dropForeign('products_section_id_foreign');
            $table->dropColumn('section_id');
        });

        Schema::dropIfExists('sections');
        Schema::dropIfExists('classifications');
    }
}
