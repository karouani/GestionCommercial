<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->increments('id_facture');
            $table->string('reference_f')->nullable();
            $table->string('fk_bl')->nullable();
            $table->date('date_f')->nullable();
            $table->string('type_operation_f')->nullable();
            $table->string('objet_f')->nullable();
            $table->string('adresse_f')->nullable();
            $table->date('date_emission_f')->nullable();
            $table->double('remise_total_f')->nullable();
            $table->double('majoration_f')->nullable();
            $table->date('date_limit_f')->nullable();
            $table->string('introduction_f')->nullable();
            $table->string('conditions_reglements_f')->nullable();
            $table->string('notes_f')->nullable();
            $table->double('accompte_f')->nullable();

            $table->double('total_ht_f')->nullable();
            $table->double('remise_ht_f')->nullable();
            $table->double('montant_net_f')->nullable();
            $table->double('tva_montant_f')->nullable();
            $table->double('montant_ttc_f')->nullable();
            $table->string('total_lettre_f')->nullable();
            $table->string('montant_reste_f')->nullable();

            $table->string('fk_status_f')->nullable();
            $table->integer('fk_compte_f')->nullable();
            $table->integer('fk_user_f')->nullable();
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
        Schema::dropIfExists('factures');
    }
}
