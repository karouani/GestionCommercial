<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaCompagnieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maCompagnies', function (Blueprint $table) {
            $table->increments('id_compagnie');
            $table->string('raison_sociale')->nullable();
            $table->string('nom_societe')->nullable();
            $table->integer('taille_comp')->nullable();
            $table->string('secteur_activite')->nullable();
            $table->string('adresse_comp')->nullable();
            $table->integer('cp_comp')->nullable();
            $table->string('ville_comp')->nullable();
            $table->string('pays_comp')->nullable();
            $table->string('tel_comp')->nullable();
            $table->string('fix_comp')->nullable();
            $table->string('webSite_comp')->nullable();
            $table->string('logo_comp')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('maCompagnies');
    }
}
