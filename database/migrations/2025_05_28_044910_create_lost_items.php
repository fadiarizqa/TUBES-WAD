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
        Schema::create('lost_items', function (Blueprint $table) {
            $table->id();
            $table->string('posting_type'); 
            $table->string('full_name');
            $table->string('lost_item_name'); 
            $table->string('item_type');
            $table->text('item_description')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('social_media')->nullable();
            $table->string('item_photo')->nullable(); 
            $table->string('lost_location'); 
            $table->date('lost_date');    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lost_items');
    }
};