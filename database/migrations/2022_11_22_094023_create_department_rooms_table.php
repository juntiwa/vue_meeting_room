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
        Schema::create('department_room_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name_th')->unique();
            $table->string('name_en')->unique();
            $table->timestamps();
        });

        Schema::create('department_purpose_book_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name_th')->unique();
            $table->string('name_en')->unique();
            $table->timestamps();
        });

        Schema::create('department_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name_th')->unique();
            $table->string('name_en')->unique();
            $table->string('short_name_th')->unique();
            $table->string('short_name_en')->unique();
            $table->unsignedTinyInteger('minimum_attendees');
            $table->unsignedSmallInteger('maximum_attendees');
            $table->unsignedSmallInteger('advance_booking_under_days');
            $table->string('location_th');
            $table->string('location_en');
            $table->string('price_half');
            $table->string('price_full');
            $table->foreignId('status_id');
            $table->foreign('status_id')->references('id')->on('department_room_statuses');
            $table->json('images');
            $table->boolean('can_set_table');
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
        Schema::dropIfExists('department_book_rooms');
        Schema::dropIfExists('department_purpose_book_rooms');
        Schema::dropIfExists('department_room_statuses');
    }
};
