<?php

use App\Models\WebsiteTestimonial;
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
        Schema::create('website_testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('designation')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('media_id')->nullable();
            $table->text('image')->nullable();
            $table->text('logo')->nullable();
            $table->string('rating')->nullable()->default(5);
            $table->tinyInteger('status')->default(1)->comment('0 inactive, 1 active');
            $table->timestamps();
        });

        WebsiteTestimonial::create([
            'name'        => 'Sarah L.',
            'designation' => 'Digital Marketer',
            'description' => 'SocialVibe has completely transformed how we manage our social media. The AI content generator saves us hours every week, and the scheduling feature keeps us consistent. Highly recommend it!',
        ]);
        WebsiteTestimonial::create([
            'name'        => 'John M.',
            'designation' => 'E-commerce Entrepreneur',
            'description' => 'As a small business owner, SocialVibe has been a game-changer. The intuitive interface and powerful tools make managing multiple platforms so simple. Its like having an extra team member!',
        ]);
        WebsiteTestimonial::create([
            'name'        => 'Emily R.',
            'designation' => 'Social Media Manager',
            'description' => 'The analytics and content management features are amazing! We’ve seen measurable growth in engagement since using SocialVibe, and the team loves how easy it is to use.',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_testimonials');
    }
};
