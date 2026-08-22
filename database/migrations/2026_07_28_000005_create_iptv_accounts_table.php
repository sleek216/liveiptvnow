<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iptv_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iptv_order_id')->nullable()->constrained('iptv_orders')->nullOnDelete();
            $table->foreignId('iptv_provider_id')->constrained('iptv_providers')->cascadeOnDelete();
            $table->string('username');
            $table->string('password')->nullable();
            $table->string('provider_client_id')->nullable();
            $table->string('status')->default('active'); // active, expired, disabled, pending
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iptv_accounts');
    }
};
