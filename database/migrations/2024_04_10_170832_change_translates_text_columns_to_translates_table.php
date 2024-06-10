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
        Schema::table('translates', function (Blueprint $table) {
            $table->longText('ru')->nullable()->change();
            $table->longText('kz')->nullable()->change();
            $table->longText('en')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('translates', function (Blueprint $table) {
            $table->text('ru')->nullable()->change();
            $table->text('kz')->nullable()->change();
            $table->text('en')->nullable()->change();
        });
    }
};
