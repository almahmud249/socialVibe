<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 100)->index()->nullable();
            $table->foreignId('client_id')->nullable()->constrained('clients');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->longText('content')->nullable();
            $table->longText('link')->nullable();
            $table->longText('platform_response')->nullable();
            $table->boolean('is_scheduled')->default(false);
            $table->timestamp('schedule_time')->nullable();
            $table->boolean('is_draft')->default(false);
            $table->boolean('status');
            $table->boolean('post_type')->default(false)->comment('FEED: 0 ,Story:2,REELS:1');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
