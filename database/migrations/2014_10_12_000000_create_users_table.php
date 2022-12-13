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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sap_id');
            $table->string('login')->unique();
            $table->string('full_name');
            $table->unsignedSmallInteger('unit_id')->nullable();
            $table->string('tel')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });

        Schema::create('abilities', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name')->unique();
            $table->string('label')->unique()->nullable();
            $table->timestamps();
        });

        Schema::create('roles',function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name')->unique();
            $table->string('label')->unique()->nullable();
            $table->timestamps();
        });

        Schema::create('ability_role',function (Blueprint $table) {
            $table->primary(['ability_id','role_id']);
            $table->unsignedSmallInteger('ability_id')->constrained('abilities');
            $table->unsignedSmallInteger('role_id')->constrained('roles');
            $table->timestamps();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->primary(['role_id','user_id']);
            $table->unsignedSmallInteger('role_id')->constrained('roles');
            $table->unsignedSmallInteger('user_id')->constrained('users');
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
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('ability_role');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('abilities');
        Schema::dropIfExists('users');
    }
};
