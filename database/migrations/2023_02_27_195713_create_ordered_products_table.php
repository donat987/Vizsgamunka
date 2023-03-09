<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordered_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ordersid');
            $table->unsignedBigInteger('productsid');
            $table->integer("clear_amount");
            $table->integer("gross_amount");
            $table->integer("gross_amount");
            $table->integer("piece");
            $table->timestamps();
            $table->foreign('ordersid')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('productsid')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordered_products');
    }
};
