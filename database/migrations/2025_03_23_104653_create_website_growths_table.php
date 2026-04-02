<?php

use App\Models\WebsiteGrowth;
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
        Schema::create('website_growths', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->tinyInteger('status')->default(1)->comment('0 inactive, 1 active');
            $table->timestamps();
        });

        WebsiteGrowth::create([
            'lang'        => 'en',
            'title'       => 'AI-Powered Content Generation',
            'description' => 'Experience seamless navigation with our robust UI/UX design, made for effortless user interaction.',
            'status'      => 1,
        ]);

        WebsiteGrowth::create([
            'lang'        => 'en',
            'title'       => 'Smart Post Scheduling & Automation',
            'description' => 'Experience seamless navigation with our robust UI/UX design, made for effortless user interaction.',
            'status'      => 1,
        ]);

        WebsiteGrowth::create([
            'lang'        => 'en',
            'title'       => 'Flexible Pricing Plans for Every Budget',
            'description' => 'Experience seamless navigation with our robust UI/UX design, made for effortless user interaction.',
            'status'      => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_growths');
    }
};
