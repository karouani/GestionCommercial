<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComptesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comptes', function (Blueprint $table) {
            $table->increments('id_compte');
            $table->string('nom_compte')->nullable();
            $table->string('responsable')->nullable();
            $table->string('type_compte')->nullable();
            $table->string('categorie')->nullable();
            $table->string('raison_social')->nullable();
            $table->string('reference')->nullable();
            $table->string('fixe')->nullable();
            $table->string('portable')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('site_web')->nullable();
            $table->string('secteur_activite')->nullable();
            $table->integer('taille')->nullable();
            $table->string('RC')->nullable();
            $table->string('adresse_compte')->nullable();
            $table->integer('fk_compagnie')->nullable();
            $table->string('logo_compte')->nullable();

            
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
        Schema::dropIfExists('comptes');
    }
}
