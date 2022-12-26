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
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->foreignId('meeting_room_id');
            $table->foreign('meeting_room_id')->references('id')->on('department_rooms');
            $table->unsignedInteger('attendees');
            $table->string('topic');
            $table->string('description')->nullable();
            $table->foreignId('purpose_id');
            $table->foreign('purpose_id')->references('id')->on('department_purpose_book_rooms');
            $table->json('set_room');
            $table->json('equipment');
            $table->json('food');
            $table->foreignId('requester_id');
            $table->foreign('requester_id')->references('id')->on('users');
            $table->unsignedSmallInteger('unit_level');
            $table->unsignedSmallInteger('unit_id');
            $table->unsignedTinyInteger('status')->default(1); // booked, approved, disapproved, canceled
            $table->string('reason')->nullable();
            $table->foreignId('approver_id')->nullable();
            $table->foreign('approver_id')->references('id')->on('users');
            $table->unsignedTinyInteger('questionnaire')->default(1); // wait for record, recorded, corrected
            $table->foreignId('recorder_id')->nullable();
            $table->foreign('recorder_id')->references('id')->on('users');
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
