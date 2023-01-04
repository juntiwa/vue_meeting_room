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
        Schema::create('request_equipment', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('start_time');
            $table->string('end_time');
            $table->unsignedSmallInteger('unit_level');
            $table->unsignedSmallInteger('unit_id');
            $table->string('full_name');
            $table->string('tel');
            $table->string('place');
            $table->json('equipment');
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
        Schema::dropIfExists('request_equipment');
    }
};
