<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id_article');
            $table->string('reference_art');
            $table->string('type_art');
            $table->string('designation');
            $table->string('description');
            $table->double('prix_ht_achat');
            $table->double('prix_ht_vente');
            $table->string('unite');
            $table->double('quantite');
            $table->double('quantite_min');
            $table->string('photo_art');
            $table->integer('fk_tva_applicable');
            $table->integer('fk_famille');
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
        Schema::dropIfExists('articles');
    }
}
