<?php

use App\Models\TestimonialLanguage;
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
        Schema::create('testimonial_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('testimonial_id');
            $table->string('lang');
            $table->string('name');
            $table->string('designation');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        TestimonialLanguage::create([
            'testimonial_id' => '1',
            'lang'           => 'en',
            'name'           => 'Sarah L.',
            'designation'    => 'Digital Marketer',
            'description'    => 'SocialVibe has completely transformed how we manage our social media. The AI content generator saves us hours every week, and the scheduling feature keeps us consistent. Highly recommend it!',
        ]);
        TestimonialLanguage::create([
            'testimonial_id' => '2',
            'lang'           => 'en',
            'name'           => 'John M.',
            'designation'    => 'E-commerce Entrepreneur',
            'description'    => 'As a small business owner, SocialVibe has been a game-changer. The intuitive interface and powerful tools make managing multiple platforms so simple. Its like having an extra team member!',
        ]);
        TestimonialLanguage::create([
            'testimonial_id' => '3',
            'lang'           => 'en',
            'name'           => 'Emily R.',
            'designation'    => 'Social Media Manager',
            'description'    => 'The analytics and content management features are amazing! We’ve seen measurable growth in engagement since using SocialVibe, and the team loves how easy it is to use.',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testimonial_langugaes');
    }
};
