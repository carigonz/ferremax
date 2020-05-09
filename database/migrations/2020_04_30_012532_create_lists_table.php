<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description', 70)->nullable();
            $table->string('name', 70)->nullable();
            $table->unsignedBigInteger('provider_id');
            $table->boolean('taxes')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('catalogs', function($table) {
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('catalogs', function($table) {
            $table->dropForeign('catalogs_provider_id_foreign');
        });
        Schema::dropIfExists('catalogs');
    }
}
