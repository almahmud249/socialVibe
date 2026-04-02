<?php

use App\Models\Faq;
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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->integer('ordering')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Faq::create([
            'question' => 'What is the AI-Driven Social Media Management & Post Scheduling Tool?',
            'answer' => 'This tool is an all-in-one platform for managing, scheduling, and automating social media posts across multiple platforms. It uses AI-powered features to enhance content generation, optimize ad management, and provide insights to boost engagement and performance.',
        ]);

        Faq::create([
            'question' => 'Which social media platforms can I manage with this tool?',
            'answer' => 'A single dashboard allows you to manage major social media platforms such as Facebook, Instagram, Twitter, LinkedIn, and more.',
        ]);

        Faq::create([
            'question' => 'How much time do I need to spend using this tool?',
            'answer' => 'With smart scheduling and automation features, you can manage and schedule posts, respond to messages, track performance, and handle campaigns in under 10 minutes a day.',
        ]);

        Faq::create([
            'question' => 'How does AI improve social media management?',
            'answer' => 'AI enhances content creation, optimizes ad management, and provides insights to increase engagement. It can suggest relevant content, automate responses, and optimize ad campaigns for better performance.',
        ]);

        Faq::create([
            'question' => 'Can I manage multiple social media accounts?',
            'answer' => 'Yes, the tool supports multi-account management, allowing you to manage several accounts across different platforms in one centralized dashboard.',
        ]);

        Faq::create([
            'question' => 'What features are available for team collaboration?',
            'answer' => 'The tool offers user role management, enabling businesses and agencies to assign tasks, collaborate on content creation, and streamline workflows effectively.',
        ]);

        Faq::create([
            'question' => 'Does this tool include analytics and reporting?',
            'answer' => 'Yes, it comes with advanced analytics and reporting features that track the performance of your posts, ads, and campaigns. These features help you optimize strategies and maximize ROI.',
        ]);

        Faq::create([
            'question' => 'How does AI-powered ad management work?',
            'answer' => 'The AI-driven ad management system helps you create, schedule, and optimize ads across social platforms to increase reach and conversions. It analyzes data to ensure your ads perform at their best.',
        ]);

        Faq::create([
            'question' => 'How does the auto-reply and chatbot integration work?',
            'answer' => 'The tool includes AI-powered auto-reply bots that can respond to comments and messages automatically, ensuring 24/7 engagement with your audience.',
        ]);

        Faq::create([
            'question' => 'Is this tool scalable for different business types?',
            'answer' => 'Yes, this tool is perfect for businesses of all types, including eCommerce, service-based industries, and content creators. It scales with your business needs, making it an ideal solution as your business grows.',
        ]);

        Faq::create([
            'question' => 'What do users say about this tool?',
            'answer' => 'Users love how the tool streamlines social media management, saves time, and boosts engagement. Social media coordinators, content managers, and brand strategists have all praised its AI-powered features and ease of use.',
        ]);

        Faq::create([
            'question' => 'Can I run ad campaigns with this tool?',
            'answer' => 'Absolutely! The tool enables you to create, schedule, and manage social media ad campaigns across multiple platforms to drive targeted traffic and increase conversions.',
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_faqs');
    }
};
