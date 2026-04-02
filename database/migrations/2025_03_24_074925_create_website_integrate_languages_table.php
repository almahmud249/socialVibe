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
        Schema::create('website_integrate_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('website_integrates_id');
            $table->foreign('website_integrates_id')->references('id')->on('website_integrates')->onDelete('cascade');
            $table->string('title');
            $table->string('lang');
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
        Schema::dropIfExists('website_integrate_languages');
    }
};
