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
        Schema::create('attribute_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->constrained('attributes')->cascadeOnDelete();

            $table->string('label'); // Мелованная 300г
            $table->string('value'); // mel300
            $table->integer('price_delta')->default(0); // надбавка в ₽ (опционально)
            $table->integer('sort')->default(100);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['attribute_id', 'value']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_options');
    }
};
