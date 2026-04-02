<?php

use App\Models\WebsiteAdvantage;
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
        Schema::create('website_advantages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('image');
            $table->longText('description');
            $table->enum('status', [0, 1])->default(1);
            $table->timestamps();
        });

        WebsiteAdvantage::create([
            'title'       => 'A User-Friendly Interface Gives You Easy Campaign Management Experience',
            'description' => '',
            'status'      => 1,
            'image'       => '',
        ]);

        WebsiteAdvantage::create([
            'title'       => 'Aggressive Telegram Marketing',
            'description' => 'Launch smooth Telegram campaigns and send unlimited messages, enjoying an impressive 80% open rate.',
            'status'      => 1,
            'image'       => '',
        ]);
        WebsiteAdvantage::create([
            'title'       => 'Meta Verified Cloud API WhatsApp Marketing',
            'description' => 'Send Unlimited WhatsApp Campaign without getting blocked by Meta and get up to 98% read rate.',
            'status'      => 1,
            'image'       => '',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_advantages');
    }
};
