<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWorkingDaysTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('working_days_types', function (Blueprint $table) {
            $table->foreign('day_types_id', 'fk_working_days_has_day_types_day_types1')->references('id')->on('day_types')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('working_days_id', 'fk_working_days_has_day_types_working_days')->references('id')->on('working_days')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('working_days_types', function (Blueprint $table) {
            $table->dropForeign('fk_working_days_has_day_types_day_types1');
            $table->dropForeign('fk_working_days_has_day_types_working_days');
        });
    }
}
