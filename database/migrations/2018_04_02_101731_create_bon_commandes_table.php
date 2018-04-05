<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonCommandes', function (Blueprint $table) {
            $table->increments('id_bc');
            $table->string('reference_bc')->nullable();
            $table->date('date_bc')->nullable();
            $table->string('type_operation_bc')->nullable();
            $table->string('objet_bc')->nullable();
            $table->date('date_emission_bc')->nullable();
            $table->double('remise_total_bc')->nullable();
            $table->double('majoration_bc')->nullable();
            $table->date('date_limit_bc')->nullable();
            $table->string('introduction_bc')->nullable();
            $table->string('conditions_reglements_bc')->nullable();
            $table->string('notes_bc')->nullable();
            $table->string('adresse_bc')->nullable();
            $table->double('accompte_bc')->nullable();
            $table->integer('fk_status_bc')->nullable();
            $table->integer('fk_compte_bc')->nullable();
            $table->integer('fk_user_bc')->nullable();
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
        Schema::dropIfExists('bonCommandes');
    }
}
