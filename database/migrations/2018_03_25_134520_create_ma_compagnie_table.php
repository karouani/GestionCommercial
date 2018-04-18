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
            //ENTREPRISE
            $table->string('raison_sociale_comp')->nullable();
            $table->string('nom_societe_comp')->nullable();
            
            $table->string('RC_comp')->nullable();
            $table->string('IF_comp')->nullable();
            $table->string('patente_comp')->nullable();
            $table->string('cnss_comp')->nullable();
            $table->string('ICE_comp')->nullable();
            $table->string('capitale_comp')->nullable();

            $table->integer('taille_comp')->nullable();
            $table->string('secteur_activite_comp')->nullable();
            // DETAILS BANCAIRE
            $table->string('nom_bank_comp')->nullable();
            $table->string('RIB_comp')->nullable();
            
            //CONTACT            
            $table->string('adresse_comp')->nullable();
            $table->string('email_comp')->nullable();
            $table->string('GSM_comp')->nullable();
            $table->string('fix_comp')->nullable();
            $table->string('fax_comp')->nullable();
            $table->string('webSite_comp')->nullable();
            $table->string('logo_comp')->nullable();



            //autres
            $table->integer('cp_comp')->nullable();
            $table->string('ville_comp')->nullable();
            $table->string('pays_comp')->nullable();
           
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
