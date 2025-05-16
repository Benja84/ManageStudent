<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute les migrations.
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            // Informations personnelles
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique(); // Champ requis dans le contrôleur
            $table->string('phone');
            $table->enum('gender', ['Homme', 'Femme']); // Enum pour limiter les valeurs
            $table->date('birth');
            $table->string('nationality');
            $table->string('address')->nullable();
            $table->string('photo')->nullable();

            // Liens avec utilisateur et conseiller
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('advisor_id')->nullable();

            // Statut et commentaires
            $table->string('status', 60)->nullable();
            $table->longText('comments')->nullable();

            // Informations sur le premier parent

            // mere
            $table->string('father_firstname')->nullable();
            $table->string('father_lastname')->nullable();
            $table->string('father_company')->nullable();
            $table->string('father_phone')->nullable();
            $table->text('father_message')->nullable();
            //pere
            $table->string('mother_firstname')->nullable();
            $table->string('mother_lastname')->nullable();
            $table->string('mother_company')->nullable();
            $table->string('mother_phone')->nullable();
            $table->text('mother_message')->nullable();


            $table->string('parent1_gender', 60)->nullable();
            $table->string('parent1_firstname', 60)->nullable();
            $table->string('parent1_lastname', 60)->nullable();
            $table->string('parent1_relation', 60)->nullable();
            $table->string('parent1_phone', 60)->nullable();
            $table->string('parent1_email', 60)->nullable();

            // Informations sur le deuxième parent
            $table->string('parent2_gender', 60)->nullable();
            $table->string('parent2_firstname', 60)->nullable();
            $table->string('parent2_lastname', 60)->nullable();
            $table->string('parent2_relation', 60)->nullable();
            $table->string('parent2_phone', 60)->nullable();
            $table->string('parent2_email', 60)->nullable();

            // Adresse des parents
            $table->string('parent_address_street', 150)->nullable();
            $table->string('parent_address_postcode', 60)->nullable();
            $table->string('parent_address_city', 60)->nullable();

            $table->timestamps();

            // Clés étrangères
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('advisor_id')
                ->references('id')->on('advisors')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Annule les migrations.
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
