<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iptv_package_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iptv_website_id')->constrained('iptv_websites')->cascadeOnDelete();
            $table->foreignId('iptv_provider_id')->constrained('iptv_providers')->cascadeOnDelete();
            $table->string('external_package_id')->nullable();
            $table->string('external_package_name')->nullable();
            $table->string('provider_package_id')->nullable();
            $table->integer('duration_days')->default(30);
            $table->integer('max_connections')->default(1);
            $table->json('bouquet_ids')->nullable();
            $table->boolean('is_trial')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iptv_package_mappings');
    }
};
