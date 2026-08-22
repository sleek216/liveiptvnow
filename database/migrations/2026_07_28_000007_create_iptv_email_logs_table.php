<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iptv_email_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iptv_order_id')->constrained('iptv_orders')->cascadeOnDelete();
            $table->string('customer_email');
            $table->string('status')->default('sent'); // sent, failed
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iptv_email_logs');
    }
};
