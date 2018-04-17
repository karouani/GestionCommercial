<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModePaiementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mode_paiements', function (Blueprint $table) {
            $table->increments('id_modeP');
            $table->string('reference_paiement')->nullable();
            $table->date('date_paiement')->nullable();
            $table->string('fk_document')->nullable();
            $table->integer('fk_type_paiement')->nullable();
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
        Schema::dropIfExists('mode_paiements');
    }
}
