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

            $table->unsignedBigInteger('store_id')->unsigned()->nullable();
            $table->unsignedBigInteger('subcategory_id')->unsigned()->nullable();
            //RELACTIONS
            $table->foreign('store_id')->references('id')->on('stores')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('subcategory_id')->references('id')->on('categories')
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
