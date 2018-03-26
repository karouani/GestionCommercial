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
            $table->string('raison_sociale');
            $table->integer('taille_comp');
            $table->string('secteur_activite');
            $table->string('adresse_comp');
            $table->integer('cp_comp');
            $table->string('ville_comp');
            $table->string('pays_comp');
            $table->string('tel_comp');
            $table->string('fix_comp');
            $table->string('webSite_comp');
            $table->string('logo_comp');
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
