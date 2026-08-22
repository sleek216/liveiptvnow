<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            if (!Schema::hasColumn('packages', 'duration')) {
                $table->string('duration')->nullable()->after('duration_label');
            }
            if (!Schema::hasColumn('packages', 'category')) {
                $table->string('category')->nullable()->after('duration');
            }
            if (!Schema::hasColumn('packages', 'devices')) {
                $table->integer('devices')->default(1)->after('connections');
            }
        });

        // Sync devices with connections if it was already there
        if (Schema::hasColumn('packages', 'connections') && Schema::hasColumn('packages', 'devices')) {
            DB::table('packages')->update(['devices' => DB::raw('connections')]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['duration', 'category', 'devices']);
        });
    }
};
