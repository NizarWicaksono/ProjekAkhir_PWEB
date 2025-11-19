<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('race_id')->constrained()->onDelete('cascade'); // Relasi ke Balapan
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Siapa yang beli (Bisa kosong kalau belum laku)
            $table->string('ticket_code')->unique(); // Kode unik tiket
            $table->string('category_name'); // Misal: "Grandstand", "VIP"
            $table->decimal('price', 15, 2); // Harga Tiket
            $table->enum('status', ['available', 'sold'])->default('available');
            $table->timestamp('purchase_date')->nullable(); // Tanggal beli (penting untuk laporan)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
