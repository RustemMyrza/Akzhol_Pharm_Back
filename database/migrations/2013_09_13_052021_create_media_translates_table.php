<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('media_translates', function (Blueprint $table) {
            $table->id();
            $table->text('ru')->nullable();
            $table->text('kz')->nullable();
            $table->text('en')->nullable();
            $table->unsignedBigInteger('ru_size')->nullable();
            $table->unsignedBigInteger('kz_size')->nullable();
            $table->unsignedBigInteger('en_size')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_translates');
    }
};
