<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBilansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bilans', function (Blueprint $table) {
            $table->increments('id_bilan');
            $table->string('mois_b')->nullable();
            $table->string('annee_b')->nullable();
            $table->string('debit_b')->nullable();
            $table->string('credit_b')->nullable();
            $table->string('difference_b')->nullable();
            $table->string('solde_depart_b')->nullable();
            $table->string('etat_b')->nullable();

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
        Schema::dropIfExists('bilans');
    }
}
