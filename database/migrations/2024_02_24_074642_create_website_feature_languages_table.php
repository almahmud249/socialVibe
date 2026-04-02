<?php

use App\Models\WebsiteFeatureLanguage;
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
        Schema::create('website_feature_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('website_feature_id');
            $table->string('lang');
            $table->string('title');
            $table->longText('description');
            $table->timestamps();
        });
        WebsiteFeatureLanguage::create([
            'website_feature_id' => '1',
            'lang'               => 'en',
            'title'              => 'AI-Powered Content Generation',
            'description'        => 'Create engaging posts effortlessly with AI that crafts tailored content for your audience.',
        ]);
        WebsiteFeatureLanguage::create([
            'website_feature_id' => '2',
            'lang'               => 'en',
            'title'              => 'Smart Content Management',
            'description'        => 'Organize, edit, and manage all your social media content in one centralized platform.',
        ]);
        WebsiteFeatureLanguage::create([
            'website_feature_id' => '3',
            'lang'               => 'en',
            'title'              => 'Post Scheduling Made Easy',
            'description'        => 'Plan, schedule, and automate your posts across multiple platforms to save time and stay consistent.',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_feature_languages');
    }
};
