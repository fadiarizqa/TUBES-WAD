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
        Schema::table('claim_users', function (Blueprint $table) {
            // Tambahkan kolom 'status' setelah 'bukti_kepemilikan' atau di akhir
            // Anda bisa memilih untuk membuatnya nullable() atau memberikan nilai default
            $table->string('status')->default('pending')->after('bukti_kepemilikan');
            // Atau jika Anda tidak ingin default value:
            // $table->string('status');
            // Atau jika status bisa null:
            // $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('claim_users', function (Blueprint $table) {
            // Ini penting untuk menghapus kolom jika migrasi di-rollback
            $table->dropColumn('status');
        });
    }
};