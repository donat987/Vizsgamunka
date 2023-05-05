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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->integer('discount_amount');
            $table->integer('discount_percentage');
            $table->string('couponcode');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->boolean('active');
            $table->timestamps();
            $table->unsignedBigInteger('speciesid');
            $table->integer('piece');
            $table->foreign('speciesid')->references('id')->on('couponspecies')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};
