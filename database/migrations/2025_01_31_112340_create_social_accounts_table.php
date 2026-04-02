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
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 100)->index()->nullable();
            $table->unsignedBigInteger('platform_id')->index();
            $table->unsignedBigInteger('subscription_id')->index()->nullable();
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->unsignedBigInteger('admin_id')->index()->nullable();
            $table->string('name', 155)->index()->nullable();
            $table->string('account_id', 191)->index()->nullable();
            $table->text('account_information')->nullable();
            $table->boolean('status')->comment('Disconnected: 0, Connected: 1');
            $table->boolean('is_official')->comment('Yes: 1, No: 1');
            $table->boolean('is_connected')->default(true)->comment('Yes: 1, No: 0');
            $table->boolean('account_type')->comment('Profile: 0, Page: 1 ,Group:2');
            $table->string('details', 255)->nullable();
            $table->text('token');
            $table->dateTime('access_token_expire_at')->nullable();

            $table->text('refresh_token')->nullable();
            $table->dateTime('refresh_token_expire_at')->nullable();

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
        Schema::dropIfExists('social_accounts');
    }
};
