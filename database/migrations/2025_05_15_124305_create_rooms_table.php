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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
	        $table->string('number')->nullable();
	        $table->string('department')->nullable();
	        $table->smallInteger('floor')->nullable();
	        $table->unsignedInteger('seating_capacity')->nullable();
	        $table->unsignedInteger('material_capacity')->nullable();
            $table->string('computer_type')->nullable();
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
        Schema::dropIfExists('rooms');
    }
};
