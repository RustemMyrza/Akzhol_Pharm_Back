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
        Schema::create('reviews_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('description')->nullable()->constrained('translates')->nullOnDelete();
            $table->foreignId('content')->nullable()->constrained('translates')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews_contents');
    }
};
