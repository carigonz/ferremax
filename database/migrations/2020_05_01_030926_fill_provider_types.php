<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FillProviderTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $now = Carbon::now();
        DB::table('provider_types')->insert([
            [
                'type' => 'Corredor',
                'description' => 'Persona representante de más de una empresa/distribuidora.',
                'created_at' => $now
            ],
            [
                'type' => 'Distribuidora',
                'description' => 'Distribuidora multimarca, o empresa dedicada a un solo rubro.',
                'created_At' => $now
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('provider_types')->truncate();
    }
}
