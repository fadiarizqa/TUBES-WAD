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
        Schema::create('claim_requests', function (Blueprint $table) {
            $table->id();
            $table->enum('item_type', ['lost', 'found', 'none'])->default('none');
            $table->enum('action', ['post', 'delete', 'claim', 'none'])->default('none');
            $table->foreignId('item_id')->nullable()->constrained('found_items')->onDelete('cascade');
            $table->text('message');
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claim_requests');
    }
};
