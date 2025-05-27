<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute les migrations pour créer la table 'professors'.
     *
     * @return void
     */
    public function up()
    {
        // Crée une nouvelle table 'professors' dans la base de données
        Schema::create('professors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('photo')->nullable();
            $table->longText('comments')->nullable();
            $table->timestamps();

            // Définition de la clé étrangère pour 'user_id'
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Annule les migrations en supprimant la table 'professors'.
     *
     * @return void
     */
    public function down()
    {
        // Supprime la table 'professors' si elle existe
        Schema::dropIfExists('professors');
    }
};
