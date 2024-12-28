<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('weather_alerts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->enum('channel_type', ['email', 'webpush']);
            $table->tinyInteger('precipitation')->unsigned();
            $table->tinyInteger('uv')->unsigned();
            $table->boolean('is_active')->default(true);
            $table->dateTime('executed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_alerts');
    }
};
