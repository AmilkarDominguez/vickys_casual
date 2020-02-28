<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->enum('state', ['ACTIVO', 'INACTIVO','ELIMINADO'])->default('ACTIVO');
            $table->text('barcode');
            $table->text('store');
            $table->text('product');
            $table->text('category');
            $table->text('subcategory');
            $table->decimal('price',8,2);
            $table->decimal('discount',8,2);
            $table->decimal('price_discount',8,2);
            $table->unsignedBigInteger('user_id')->unsigned();
            // $table->unsignedBigInteger('product_id')->unsigned();
            //RELACTIONS
            $table->foreign('user_id')->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            // $table->foreign('product_id')->references('id')->on('products')
            // ->onDelete('cascade')
            // ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
