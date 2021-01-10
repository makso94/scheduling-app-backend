<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAppointmentsHasServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments_has_services', function (Blueprint $table) {
            $table->foreign('appointments_id', 'fk_appointments_has_services_appointments')->references('id')->on('appointments')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('services_id', 'fk_appointments_has_services_services')->references('id')->on('services')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments_has_services', function (Blueprint $table) {
            $table->dropForeign('fk_appointments_has_services_appointments');
            $table->dropForeign('fk_appointments_has_services_services');
        });
    }
}
