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
            $table->foreign('appointments_id', 'fk_appointments_has_services_appointments1')->references('id')->on('appointments')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('services_id', 'fk_appointments_has_services_services1')->references('id')->on('services')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
            $table->dropForeign('fk_appointments_has_services_appointments1');
            $table->dropForeign('fk_appointments_has_services_services1');
        });
    }
}
