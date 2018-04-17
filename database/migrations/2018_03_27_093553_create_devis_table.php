<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devis', function (Blueprint $table) {
            $table->increments('id_devis');
            $table->string('reference_d')->nullable();
            $table->date('date_d')->nullable();
            $table->string('type_operation')->nullable();
            $table->string('objet_d')->nullable();
            $table->string('adresse_d')->nullable();
            $table->date('date_emission_d')->nullable();
            $table->double('remise_total_d')->nullable();
            $table->double('majoration_d')->nullable();
            $table->date('date_limit_d')->nullable();
            $table->string('introduction_d')->nullable();
            $table->string('conditions_reglements_d')->nullable();
            $table->string('notes_d')->nullable();
            $table->double('accompte_d')->nullable();

            $table->double('total_ht_d')->nullable();
            $table->double('remise_ht_d')->nullable();
            $table->double('montant_net_d')->nullable();
            $table->double('tva_montant_d')->nullable();
            $table->double('montant_ttc_d')->nullable();
            $table->string('total_lettre_d')->nullable();

            $table->string('fk_status_d')->nullable();
            $table->integer('fk_compte_d')->nullable();
            $table->integer('fk_user_d')->nullable();
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
        Schema::dropIfExists('devis');
    }
}
