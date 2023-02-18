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
        Schema::create('coupon_category', function (Blueprint $table) {
            $table->unsignedBigInteger('couponid');
            $table->unsignedBigInteger('categoryid');
            $table->timestamps();
            $table->foreign('couponid')->references('id')->on('coupons')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('categoryid')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_category');
    }
};
