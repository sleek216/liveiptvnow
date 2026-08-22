<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iptv_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iptv_website_id')->constrained('iptv_websites')->cascadeOnDelete();
            $table->string('external_order_id')->nullable();
            $table->string('external_package_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('payment_status')->default('pending'); // pending, completed, failed
            $table->string('order_status')->default('pending');
            $table->string('iptv_status')->default('pending'); // pending, created, failed
            $table->string('email_status')->default('pending'); // pending, sent, failed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iptv_orders');
    }
};
