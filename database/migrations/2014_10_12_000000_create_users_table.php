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
			$table->string('gender', 60)->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
			$table->string('phone', 60)->unique();

            $table->date('dateofbirth');
			$table->string('birthplace_postcode', 60)->nullable();
			$table->string('birthplace_city', 60)->nullable();

            $table->string('address_street', 150)->nullable();
			$table->string('address_postcode', 60)->nullable();
			$table->string('address_city', 60)->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
			$table->boolean('active')->default(TRUE);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
