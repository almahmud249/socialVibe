<?php

use App\Models\WebsiteGrowthLanguage;
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
        Schema::create('website_growth_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('website_growth_id');
            $table->foreign('website_growth_id')->references('id')->on('website_growths')->onDelete('cascade');
            $table->string('lang');
            $table->string('title');
            $table->string('description');
            $table->timestamps();
        });

        WebsiteGrowthLanguage::create([
            'website_growth_id' => 3,
            'lang'              => 'en',
            'title'             => 'Flexible Pricing Plans for Every Budget',
            'description'       => 'Experience seamless navigation with our robust UI/UX design, made for effortless user interaction.',
        ]);

        WebsiteGrowthLanguage::create([
            'website_growth_id' => 1,
            'lang'              => 'en',
            'title'             => 'AI-Powered Content Generation',
            'description'       => 'Experience seamless navigation with our robust UI/UX design, made for effortless user interaction.',
        ]);

        WebsiteGrowthLanguage::create([
            'website_growth_id' => 2,
            'lang'              => 'en',
            'title'             => 'Smart Post Scheduling & Automation',
            'description'       => 'Experience seamless navigation with our robust UI/UX design, made for effortless user interaction.',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_growth_languages');
    }
};
