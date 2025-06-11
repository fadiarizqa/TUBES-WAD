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
        Schema::create('found_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('posting_type');
            $table->string('full_name');
            $table->string('found_item_name');
            $table->string('item_type');
            $table->text('item_description')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('social_media')->nullable();
            $table->string('item_photo')->nullable();
            $table->string('found_location');
            $table->date('found_date'); 
            $table->enum('status', ['ditemukan', 'diklaim', 'none'])->default('ditemukan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('found_items');
        
    }
};