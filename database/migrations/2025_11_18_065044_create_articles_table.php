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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');        // Judul Berita
            $table->text('content');        // Isi Berita (bisa panjang)
            $table->string('image')->nullable(); // Foto Utama
            $table->foreignId('user_id')->constrained(); // Siapa penulisnya (Admin)
            $table->date('published_date'); // Tanggal tayang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
