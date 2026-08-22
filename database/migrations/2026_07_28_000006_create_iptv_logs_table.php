<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iptv_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iptv_website_id')->nullable()->constrained('iptv_websites')->nullOnDelete();
            $table->foreignId('iptv_order_id')->nullable()->constrained('iptv_orders')->nullOnDelete();
            $table->string('action'); // order_created, account_created, failed, etc.
            $table->string('status')->default('success'); // success, error
            $table->text('description')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iptv_logs');
    }
};
