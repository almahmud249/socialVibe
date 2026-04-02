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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('when_post')->nullable()->after('images');
            $table->dateTime('start_time')->nullable()->after('when_post');
            $table->string('interval')->nullable()->after('start_time');
            $table->string('repost_frequency')->nullable()->after('interval');
            $table->dateTime('end_time')->nullable()->after('repost_frequency');
            $table->text('specific_times')->nullable()->after('end_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            //
        });
    }
};
