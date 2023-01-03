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
        Schema::create('unit_outters', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('unit_id');
            $table->unsignedSmallInteger('unit_level_id');
            $table->string('name_th');
            $table->string('name_en')->nullable();
            $table->string('shot_name_th')->nullable();
            $table->string('shot_name_en')->nullable();
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
        Schema::dropIfExists('unit_outters');
    }
};
