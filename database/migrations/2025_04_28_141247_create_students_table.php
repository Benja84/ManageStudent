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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('advisor_id')->nullable();

			$table->string('status', 60)->nullable();

			$table->longText('comments')->nullable();

			$table->string('parent1_gender', 60)->nullable();
			$table->string('parent1_firstname', 60)->nullable();
			$table->string('parent1_lastname', 60)->nullable();
			$table->string('parent1_relation', 60)->nullable();
			$table->string('parent1_phone', 60)->nullable();
			$table->string('parent1_email', 60)->nullable();

			$table->string('parent2_gender', 60)->nullable();
			$table->string('parent2_firstname', 60)->nullable();
			$table->string('parent2_lastname', 60)->nullable();
			$table->string('parent2_relation', 60)->nullable();
			$table->string('parent2_phone', 60)->nullable();
			$table->string('parent2_email', 60)->nullable();

			$table->string('parent_address_street', 150)->nullable();
			$table->string('parent_address_postcode', 60)->nullable();
			$table->string('parent_address_city', 60)->nullable();
            $table->timestamps();

            // Foreign keys (clé etrangère)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('advisor_id')->references('id')->on('advisors')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
