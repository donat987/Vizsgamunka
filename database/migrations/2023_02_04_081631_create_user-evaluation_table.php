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
        Schema::create('user-evaluation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userid');
            $table->unsignedBigInteger('evaluationid');
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('evaluationid')->references('id')->on('evaluation')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_evaluation');
    }
};
