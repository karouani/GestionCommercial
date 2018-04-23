<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonLivraisonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonLivraisons', function (Blueprint $table) {
            //type_devis  ---> operation_bl / 
            $table->increments('id_bl');
            $table->string('reference_bl')->nullable();
            $table->string('fk_bonCommande')->nullable();
            $table->date('date_bl')->nullable();
            $table->string('type_operation_bl')->nullable();
            $table->string('objet_bl')->nullable();
            $table->date('date_emission_bl')->nullable();
            $table->double('remise_total_bl')->nullable();
            $table->double('majoration_bl')->nullable();
            $table->date('date_limit_bl')->nullable();
            $table->string('introduction_bl')->nullable();
            $table->string('conditions_reglements_bl')->nullable();
            $table->string('notes_bl')->nullable();
            $table->string('adresse_bl')->nullable();
            $table->double('accompte_bl')->nullable();
            $table->double('total_ht_bl')->nullable();
            $table->double('remise_ht_bl')->nullable();
            $table->double('montant_net_bl')->nullable();
            $table->double('tva_montant_bl')->nullable();
            $table->double('montant_ttc_bl')->nullable();

            $table->string('fk_status_bl')->nullable();
            $table->integer('fk_compte_bl')->nullable();
            $table->integer('fk_user_bl')->nullable();

            $table->integer('fk_contact')->nullable();
            $table->string('adresse_facture_bl')->nullable();
            
            $table->string('total_lettre')->nullable();

            $table->double('montant_reste_bl')->nullable();

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
        Schema::dropIfExists('bonLivraisons');
    }
}
