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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('statesid');
            $table->unsignedBigInteger('userid');
            $table->string("zipcode");
            $table->string("name");
            $table->string("city");
            $table->string("street");
            $table->string("house_number");
            $table->string("other");
            $table->string("tax_number");
            $table->string("mobile_number");
            $table->string("email");
            $table->string("company_name");
            $table->string("company_zipcode");
            $table->string("company_city");
            $table->string("company_street");
            $table->string("company_house_number");
            $table->unsignedBigInteger('shippingid');
            $table->unsignedBigInteger('couponid');
            $table->timestamps();
            $table->foreign('couponid')->references('id')->on('coupons')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('statesid')->references('id')->on('states')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('shippingid')->references('id')->on('shipping_methods')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
