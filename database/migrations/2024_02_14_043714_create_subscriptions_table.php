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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->string('is_recurring');
            $table->integer('team_limit')->nullable();
            $table->integer('team_limit_remaining')->default(0)->nullable();
            $table->integer('profile_limit')->nullable();
            $table->integer('profile_limit_remaining')->default(0)->nullable();
            $table->integer('post_limit')->nullable();
            $table->integer('post_limit_remaining')->default(0)->nullable();
            $table->dateTime('purchase_date')->nullable();
            $table->double('price')->default(0);
            $table->string('package_type')->nullable();
            $table->boolean('status')->default(0)->comment('0:pending,1:active,2:rejected,3:inactive');
            $table->date('expire_date')->nullable();
            $table->string('trx_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->text('payment_details')->nullable();
            $table->string('billing_name')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_zip_code')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('billing_phone')->nullable();
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
        Schema::dropIfExists('subscriptions');
    }
};
