<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsHasServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments_has_services', function (Blueprint $table) {
            $table->unsignedInteger('appointments_id')->index('fk_appointments_has_services_appointments1_idx');
            $table->unsignedInteger('services_id')->index('fk_appointments_has_services_services1_idx');
            $table->primary(['appointments_id', 'services_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments_has_services');
    }
}
