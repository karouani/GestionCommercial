<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->increments('id_cmd');
            $table->double('quantite_cmd')->nullable();
            $table->double('remise_cmd')->nullable();
            $table->double('majoration_cmd')->nullable();
            $table->double('prix_ht')->nullable();
            $table->integer('fk_article')->nullable();
            $table->string('fk_document')->nullable();
            $table->integer('fk_tva_cmd')->nullable();
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
        Schema::dropIfExists('commandes');
    }
}
