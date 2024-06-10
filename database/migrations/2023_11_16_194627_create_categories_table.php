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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('title')->nullable()->constrained('translates')->nullOnDelete();

            $table->string('slug')->unique();
            $table->boolean('is_new')->default(1);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_important')->default(0);
            $table->unsignedInteger('position')->default(1);

            $table->foreignId('meta_title')->nullable()->constrained('translates')->nullOnDelete();
            $table->foreignId('meta_description')->nullable()->constrained('translates')->nullOnDelete();
            $table->foreignId('meta_keyword')->nullable()->constrained('translates')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
