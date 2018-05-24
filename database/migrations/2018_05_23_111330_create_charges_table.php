<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->increments('id_charge');
            $table->string('num_facture_ch')->nullable();
            $table->date('date_facture_ch')->nullable();
            $table->string('nom_fournisseur_ch')->nullable();
            $table->string('designation_ch')->nullable();
            $table->double('montant_ht_ch')->nullable();
            $table->double('taux_tva_ch')->nullable();
            $table->double('tva_ch')->nullable();
            $table->double('montant_ttc_ch')->nullable();
            $table->string('mode_paiement_ch')->nullable();
            $table->string('reference_ch')->nullable();
            $table->date('date_paiement_ch')->nullable();
            $table->string('support_ch')->nullable();
            $table->string('objet_ch')->nullable();
            $table->string('type_delai_ch')->nullable();
            $table->date('date_limit_ch')->nullable();

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
        Schema::dropIfExists('charges');
    }
}
