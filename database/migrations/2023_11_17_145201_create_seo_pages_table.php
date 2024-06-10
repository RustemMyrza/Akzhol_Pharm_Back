<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('title')->constrained('translates')->cascadeOnDelete();
            $table->string('page')->unique();
            $table->foreignId('meta_title')->nullable()->constrained('translates')->nullOnDelete();
            $table->foreignId('meta_description')->nullable()->constrained('translates')->nullOnDelete();
            $table->foreignId('meta_keyword')->nullable()->constrained('translates')->nullOnDelete();
            $table->boolean('is_active')->default(1);
            $table->unsignedInteger('position')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo_pages');
    }
};
