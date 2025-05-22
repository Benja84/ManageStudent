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
        Schema::table('students', function (Blueprint $table) {
            // Ne pas redéfinir firstname, lastname, email : ils existent déjà

            if (!Schema::hasColumn('students', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }

            if (!Schema::hasColumn('students', 'gender')) {
                $table->enum('gender', ['Homme', 'Femme'])->nullable()->after('phone');
            }

            if (!Schema::hasColumn('students', 'birth')) {
                $table->date('birth')->nullable()->after('gender');
            }

            if (!Schema::hasColumn('students', 'nationality')) {
                $table->string('nationality')->nullable()->after('birth');
            }

            if (!Schema::hasColumn('students', 'address')) {
                $table->string('address')->nullable()->after('nationality');
            }

            if (!Schema::hasColumn('students', 'photo')) {
                $table->string('photo')->nullable()->after('address');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'gender',
                'birth',
                'nationality',
                'address',
                'photo'
            ]);
        });
    }
};
