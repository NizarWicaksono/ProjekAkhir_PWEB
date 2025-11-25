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
        Schema::create('races', function (Blueprint $table) {
            $table->id();
            // GANTI kolom nama & sirkuit string menjadi Foreign Key
            $table->foreignId('circuit_id')->constrained('circuits')->onDelete('cascade');

            $table->dateTime('race_date');
            $table->decimal('base_price', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('races');
    }
};
