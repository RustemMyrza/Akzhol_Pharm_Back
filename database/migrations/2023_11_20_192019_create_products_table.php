<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('title')->nullable()->constrained('translates')->nullOnDelete();
            $table->foreignId('description')->nullable()->constrained('translates')->nullOnDelete();
            $table->foreignId('instruction')->nullable()->constrained('translates')->nullOnDelete();

            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('bulk_price')->default(0);
            $table->unsignedBigInteger('stock_quantity')->default(0);

            $table->string('image')->nullable();
            $table->string('vendor_code')->unique();
            $table->boolean('status')->default(0);
            $table->boolean('is_new')->default(1);
            $table->boolean('is_active')->default(1);
            $table->string('slug')->nullable()->unique();
            $table->unsignedInteger('position')->default(1);

            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();

            $table->foreignId('meta_title')->nullable()->constrained('translates')->nullOnDelete();
            $table->foreignId('meta_description')->nullable()->constrained('translates')->nullOnDelete();
            $table->foreignId('meta_keyword')->nullable()->constrained('translates')->nullOnDelete();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
