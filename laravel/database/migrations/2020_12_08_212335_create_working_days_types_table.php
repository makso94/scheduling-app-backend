<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkingDaysTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_days_types', function (Blueprint $table) {
            $table->unsignedInteger('working_days_id')->index('fk_working_days_has_day_types_working_days_idx');
            $table->unsignedInteger('day_types_id')->index('fk_working_days_has_day_types_day_types1_idx');
            $table->integer('premium')->nullable();
            $table->primary(['working_days_id', 'day_types_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('working_days_types');
    }
}
