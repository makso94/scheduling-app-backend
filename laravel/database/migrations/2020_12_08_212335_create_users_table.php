<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 32);
            $table->string('last_name', 32);
            $table->string('email', 64)->unique();
            $table->string('password');
            $table->boolean('is_admin')->nullable()->default(0);
            $table->timestamps();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('deactivated_at')->nullable();
        });


        // Insert some stuff
        DB::table('users')->insert(
            array(
                'email' => 'admin@hs.com',
                'first_name' => 'First name',
                'last_name' => 'Last name',
                'password' =>  hash('sha512', '123'),
                'is_admin' => 1,
                'approved_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
