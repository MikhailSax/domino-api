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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_group_id')->constrained('attribute_groups')->cascadeOnDelete();

            $table->string('key');   // paper, size, lamination
            $table->string('label'); // Бумага, Размер...
            $table->string('type')->default('select'); // select, number, text, bool, file
            $table->boolean('is_required')->default(false);
            $table->integer('sort')->default(100);
            $table->json('meta')->nullable(); // min/max/step/placeholder etc
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['attribute_group_id', 'key']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
