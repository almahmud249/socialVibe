<?php

use App\Models\Plan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->double('price')->default(0.00);
            $table->string('billing_period')->nullable();
            $table->integer('profile_limit')->nullable();
            $table->integer('post_limit')->nullable();
            $table->boolean('featured')->default(0)->comment('1=yes, 0=no');
            $table->integer('team_limit')->nullable();
            $table->string('color')->default('#E0E8F9');
            $table->tinyInteger('status')->default(1)->comment('0 inactive, 1 active');
            $table->timestamps();
        });

        Plan::create([
            'name'           => 'Advance',
            'description'    => '',
            'price'          => 2,
            'billing_period' => 'monthly',
            'profile_limit'  => 1000,
            'post_limit'     => 10,
            'team_limit'     => 2,
            'color'          => '#E0E8F9',

        ]);

        Plan::create([
            'name'           => 'Pro',
            'description'    => '',
            'price'          => 5,
            'billing_period' => 'monthly',
            'profile_limit'  => 10000,
            'post_limit'     => 100,
            'team_limit'     => 20,
            'featured'       => 1,
            'color'          => '#E0E8F9',
        ]);

        Plan::create([
            'name'           => 'Advance Pro',
            'description'    => '',
            'price'          => 25,
            'billing_period' => 'yearly',
            'profile_limit'  => 10000,
            'post_limit'     => 100,
            'team_limit'     => 20,
            'color'          => '#E0E8F9',
        ]);

        Plan::create([
            'name'           => 'Premium',
            'description'    => '',
            'price'          => 45,
            'billing_period' => 'yearly',
            'profile_limit'  => 10000,
            'post_limit'     => 100,
            'team_limit'     => 20,
            'color'          => '#E0E8F9',
        ]);

    }

    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
