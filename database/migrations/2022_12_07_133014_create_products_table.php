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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unsignedBigInteger('categoryid');
            $table->unsignedBigInteger('vat');
            $table->unsignedBigInteger('brandid');
            $table->string("barcode");
            $table->text('description');
            $table->integer("price");
            $table->integer("actionprice");
            $table->integer("quantity");
            $table->string("other");
            $table->string("tags");
            $table->string('picturename');
            $table->string('file');
            $table->string('capacity');
            $table->string('link');
            $table->boolean('active');
            $table->timestamps();
            $table->foreign('categoryid')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('brandid')->references('id')->on('brands')->onDelete('cascade')->onUpdate('cascade');
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
};
