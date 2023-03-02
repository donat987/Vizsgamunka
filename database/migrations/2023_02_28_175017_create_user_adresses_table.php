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
        Schema::create('user_adresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userid');
            $table->string("zipcode");
            $table->string("name");
            $table->string("city");
            $table->string("street");
            $table->string("house_number");
            $table->string("other");
            $table->string("tax_number");
            $table->string("mobile_number");
            $table->timestamps();
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
        Schema::dropIfExists('user_adresses');
    }
};
