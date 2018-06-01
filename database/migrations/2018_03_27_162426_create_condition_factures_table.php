<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConditionFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condition_factures', function (Blueprint $table) {
            $table->increments('id_condition');
            $table->string('devise')->nullable();
            $table->double('remise')->nullable();
            $table->String('delai_paiement')->nullable();
            $table->string('remarques')->nullable();
            $table->integer('fk_compte')->nullable();
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
        Schema::dropIfExists('condition_factures');
    }
}
