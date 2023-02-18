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
        Schema::create('coupon_brand', function (Blueprint $table) {
            $table->unsignedBigInteger('couponid');
            $table->unsignedBigInteger('brandid');
            $table->timestamps();
            $table->foreign('couponid')->references('id')->on('coupons')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('coupon_brand');
    }
};
