<?php

use App\Models\AuthContent;
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
        Schema::create('auth_contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('image')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0 inactive, 1 active');
            $table->timestamps();
        });

        AuthContent::create([
            'title'  => 'Simplify Your Online Growth with AI Automation',
            'status' => 1,
        ]);

        AuthContent::create([
            'title'  => 'Aggressive Telegram Marketing',
            'status' => 1,
        ]);
        AuthContent::create([
            'title'  => 'Meta Verified Cloud API WhatsApp Marketing',
            'status' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_content');
    }
};
