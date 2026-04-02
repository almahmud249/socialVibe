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
        Schema::create('post_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->dateTime('start_time');
            $table->integer('interval')->nullable();
            $table->integer('repost_frequency')->nullable();
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
        Schema::dropIfExists('post_schedules');
    }
};
