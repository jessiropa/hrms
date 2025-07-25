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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Pengaju cuti
            $table->foreignId('leave_type_id')->constrained('leave_types')->onDelete('cascade'); // Jenis cuti
            $table->date('start_date'); // Tanggal mulai cuti
            $table->date('end_date'); // Tanggal berakhir cuti
            $table->text('reason'); // Alasan cuti
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Status permintaan cuti
            $table->text('admin_notes')->nullable(); // Catatan dari admin/HR
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};