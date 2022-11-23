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
        Schema::create('department_book_rooms', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->unsignedInteger('attendees');
            $table->json('set_room');
            $table->foreignId('meeting_room_id');
            $table->foreign('meeting_room_id')->references('id')->on('department_rooms');
            $table->unsignedTinyInteger('status')->default(1); // booked, approved, disapproved, canceled
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
    }
};
