<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvoirFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avoir_factures', function (Blueprint $table) {
            $table->increments('id_af');
            $table->string('reference_af')->nullable();
            $table->string('fk_f')->nullable();
            $table->date('date_af')->nullable();
            $table->string('type_operation_af')->nullable();
            $table->string('objet_af')->nullable();
            $table->string('adresse_af')->nullable();
            $table->date('date_emission_af')->nullable();
            $table->double('remise_total_af')->nullable();
            $table->double('majoration_af')->nullable();
            $table->date('date_limit_af')->nullable();
            $table->string('introduction_af')->nullable();
            $table->string('conditions_reglements_af')->nullable();
            $table->string('notes_af')->nullable();
            $table->double('accompte_af')->nullable();

            $table->double('total_ht_af')->nullable();
            $table->double('remise_ht_af')->nullable();
            $table->double('montant_net_af')->nullable();
            $table->double('tva_montant_af')->nullable();
            $table->double('montant_ttc_af')->nullable();
            $table->string('total_lettre_af')->nullable();
            $table->string('montant_reste_af')->nullable();

            $table->string('fk_status_af')->nullable();
            $table->integer('fk_compte_af')->nullable();
            $table->integer('fk_user_af')->nullable();
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
        Schema::dropIfExists('avoir_factures');
    }
}
