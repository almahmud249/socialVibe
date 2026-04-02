<?php

use App\Models\AuthContentLanguage;
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
        Schema::create('auth_content_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auth_content_id');
            $table->foreign('auth_content_id')->references('id')->on('auth_contents')->onDelete('cascade');
            $table->string('lang');
            $table->string('title');
            $table->timestamps();
        });

        AuthContentLanguage::create([
            'auth_content_id' => 3,
            'lang'            => 'en',
            'title'           => 'A User-Friendly Interface Gives You Easy Campaign Management Experience',
        ]);

        AuthContentLanguage::create([
            'auth_content_id' => 2,
            'lang'            => 'en',
            'title'           => 'Aggressive Telegram Marketing',
        ]);

        AuthContentLanguage::create([
            'auth_content_id' => 1,
            'lang'            => 'en',
            'title'           => 'Meta Verified Cloud API WhatsApp Marketing',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_content_languages');
    }
};
