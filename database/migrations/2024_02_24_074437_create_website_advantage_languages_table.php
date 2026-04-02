<?php

use App\Models\WebsiteAdvantageLanguage;
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
        Schema::create('website_advantage_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('website_advantage_id');
            $table->string('lang');
            $table->string('title');
            $table->longText('description');
            $table->timestamps();
        });

        WebsiteAdvantageLanguage::create([
            'website_advantage_id' => 3,
            'lang'                 => 'en',
            'title'                => 'A User-Friendly Interface Gives You Easy Campaign Management Experience',
            'description'          => '',
        ]);

        WebsiteAdvantageLanguage::create([
            'website_advantage_id' => 2,
            'lang'                 => 'en',
            'title'                => 'Aggressive Telegram Marketing',
            'description'          => 'Launch smooth Telegram campaigns and send unlimited messages, enjoying an impressive 80% open rate.',
        ]);

        WebsiteAdvantageLanguage::create([
            'website_advantage_id' => 1,
            'lang'                 => 'en',
            'title'                => 'Meta Verified Cloud API WhatsApp Marketing',
            'description'          => 'Send Unlimited WhatsApp Campaign without getting blocked by Meta and get up to 98% read rate.',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_advantage_languages');
    }
};
