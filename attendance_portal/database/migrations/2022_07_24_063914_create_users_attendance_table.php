<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_attendance', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreign('name')->references('full_name')->on('users');
            $table->string('email');
            $table->foreign('email')->references('email')->on('users');
            $table->string('attendance');
            $table->text('leave_req')->nullable();
            $table->date('attendance_date');
            $table->string('leave_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_attendance');
    }
};
