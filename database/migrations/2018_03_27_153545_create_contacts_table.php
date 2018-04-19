<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id_contact');
            $table->string('prenom')->nullable();
            $table->string('nom')->nullable();
            $table->string('civilite')->nullable();
            $table->string('fonction')->nullable();
            $table->string('email')->nullable();
            $table->string('fixe')->nullable();
            $table->string('mobile')->nullable();
            $table->string('type_contact')->nullable();
            $table->integer('fk_compte_comp')->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
