<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
             $table->increments('id_vendas');
             $table->integer('produto_id')->unsigned();
             $table->foreign('produto_id')->referencs('id')->on('produtos')->onDelete('cascade');
             $table->integer('numerovenda_id')->unsigned();
             $table->foreign('numerovenda_id')->referencs('numerovenda')->on('documentos')->onDelete('cascade');
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
        Schema::drop('vendas');
    }
}
