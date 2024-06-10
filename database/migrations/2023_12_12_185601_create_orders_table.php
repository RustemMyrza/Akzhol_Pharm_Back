<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('user_type')->default(0);

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('message', 2000)->nullable();

            $table->string('organization_name')->nullable();
            $table->string('organization_bin')->nullable();
            $table->string('organization_email')->nullable();
            $table->string('organization_phone')->nullable();
            $table->string('organization_legal_address')->nullable();
            $table->string('organization_current_address')->nullable();

            $table->boolean('delivery_type')->default(0);
            $table->boolean('payment_method')->default(0);
            $table->boolean('payment_status')->default(0);
            $table->boolean('status')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
