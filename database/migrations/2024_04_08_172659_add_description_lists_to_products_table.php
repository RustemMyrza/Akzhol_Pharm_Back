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
        Schema::table('products', function (Blueprint $table) {
            $table->longText('description_lists')->after('description')->nullable();
            $table->longText('instruction_lists')->after('instruction')->nullable();
            $table->foreignId('specification_table')
                ->after('instruction')
                ->nullable()
                ->constrained('translates')
                ->nullOnDelete();

            $table->string('size_image')->after('instruction')->nullable();
            $table->longText('collapsible_diagram')->after('instruction')->nullable();
            $table->string('installation_image')->after('instruction')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'description_lists',
                'instruction_lists',
                'size_image',
                'collapsible_diagram',
                'installation_image'
            ]);

            $table->dropConstrainedForeignId('specification_table');
        });
    }
};
