<?php

use App\Models\WebsiteUniqueFeatureLanguage;
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
        Schema::create('website_unique_feature_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('website_unique_feature_id');
            $table->string('lang');
            $table->string('title');
            $table->longText('description');
            $table->timestamps();
        });

        WebsiteUniqueFeatureLanguage::create([
            'website_unique_feature_id'          => '1',
            'lang'                      => 'en',
            'title'                         => 'Social Media Integration',
            'description'                   => 'Experience seamless navigation with our robust UI/UX design, made for effortless user interaction.en',
        ]);

        WebsiteUniqueFeatureLanguage::create([
            'website_unique_feature_id'          => '2',
            'lang'                      => 'en',
            'title'                         => 'AI-Powered Content Generation',
            'description'                   => 'Experience seamless navigation with our robust UI/UX design, made for effortless user interaction.en',
        ]);

        WebsiteUniqueFeatureLanguage::create([
            'website_unique_feature_id'          => '3',
            'lang'                      => 'en',
            'title'                         => 'Smart Post Scheduling & Automation',
            'description'                   => 'Experience seamless navigation with our robust UI/UX design, made for effortless user interaction.en',
        ]);
        WebsiteUniqueFeatureLanguage::create([
            'website_unique_feature_id'          => '4',
            'lang'                      => 'en',
            'title'                         => 'AI-Powered Ad Management',
            'description'                   => 'Experience seamless navigation with our robust UI/UX design, made for effortless user interaction.en',
        ]);
        WebsiteUniqueFeatureLanguage::create([
            'website_unique_feature_id'          => '5',
            'lang'                      => 'en',
            'title'                         => 'Team Collaboration & User Roles',
            'description'                   => 'Experience seamless navigation with our robust UI/UX design, made for effortless user interaction.en',
        ]);
        WebsiteUniqueFeatureLanguage::create([
            'website_unique_feature_id'          => '6',
            'lang'                      => 'en',
            'title'                         => 'Advanced Analytics & Reporting',
            'description'                   => 'Experience seamless navigation with our robust UI/UX design, made for effortless user interaction.en',
        ]);
        WebsiteUniqueFeatureLanguage::create([
            'website_unique_feature_id'          => '7',
            'lang'                      => 'en',
            'title'                         => 'Multi-Account Management',
            'description'                   => 'Experience seamless navigation with our robust UI/UX design, made for effortless user interaction.en',
        ]);
        WebsiteUniqueFeatureLanguage::create([
            'website_unique_feature_id'          => '8',
            'lang'                      => 'en',
            'title'                         => 'Intuitive Interface for Seamless Navigation',
            'description'                   => 'Experience seamless navigation with our robust UI/UX design, made for effortless user interaction.en',
        ]);
        WebsiteUniqueFeatureLanguage::create([
            'website_unique_feature_id'          => '9',
            'lang'                      => 'en',
            'title'                         => 'Scalable for Growing Businesses',
            'description'                   => 'Experience seamless navigation with our robust UI/UX design, made for effortless user interaction.en',
        ]);
        WebsiteUniqueFeatureLanguage::create([
            'website_unique_feature_id'          => '10',
            'lang'                      => 'en',
            'title'                         => 'Flexible Pricing Plans for Every Budget',
            'description'                   => 'Experience seamless navigation with our robust UI/UX design, made for effortless user interaction.en',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_unique_feature_languages');
    }
};
