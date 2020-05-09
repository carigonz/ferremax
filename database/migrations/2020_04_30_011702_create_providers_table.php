<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 70);
            $table->string('description', 70)->nullable();
            $table->unsignedInteger('provider_type_id');
            $table->string('phone', 40)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('providers', function($table) {
            $table->foreign('provider_type_id')->references('id')->on('provider_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('providers', function($table) {
            $table->dropForeign('providers_provider_type_id_foreign');
        });
        Schema::dropIfExists('providers');
    }
}
