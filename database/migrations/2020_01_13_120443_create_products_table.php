<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->enum('state', ['ACTIVO', 'INACTIVO','ELIMINADO'])->default('ACTIVO');
            $table->text('name');
            $table->text('barcode');
            $table->text('price');
            $table->text('discount');
            $table->text('price_discount');

            $table->unsignedBigInteger('id_store')->unsigned()->nullable();
            $table->unsignedBigInteger('id_subcategory')->unsigned()->nullable();
            //RELACTIONS
            $table->foreign('id_store')->references('id')->on('stores')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('id_subcategory')->references('id')->on('categories')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
