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
            $table->string('reference_art')->nullable();
            $table->string('type_art')->nullable();
            $table->string('designation')->nullable();
            $table->string('description')->nullable();
            $table->double('prix_ht_achat')->nullable();
            $table->double('prix_ht_vente')->nullable();
            $table->string('unite')->nullable();
            $table->double('quantite')->nullable();
            $table->double('quantite_min')->nullable();
            $table->string('photo_art')->nullable();
            $table->integer('fk_tva_applicable')->nullable();
            $table->integer('fk_famille')->nullable();
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
