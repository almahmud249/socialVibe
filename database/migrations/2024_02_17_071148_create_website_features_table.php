<?php

use App\Models\WebsiteFeature;
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
        Schema::create('website_features', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('image');
            $table->longText('description');
            $table->string('type');
            $table->enum('status', [0, 1])->default(1);
            $table->timestamps();
        });

        WebsiteFeature::create([
            'type'        => 'whatsapp',
            'title'       => 'Post Scheduling Made Easy',
            'description' => 'Plan, schedule, and automate your posts across multiple platforms to save time and stay consistent.',
        ]);
        WebsiteFeature::create([
            'type'        => 'whatsapp',
            'title'       => 'Smart Content Management',
            'description' => 'Organize, edit, and manage all your social media content in one centralized platform.',
        ]);
        WebsiteFeature::create([
            'type'        => 'whatsapp',
            'title'       => 'AI-Powered Content Generation',
            'description' => 'Create engaging posts effortlessly with AI that crafts tailored content for your audience.',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_features');
    }
};
