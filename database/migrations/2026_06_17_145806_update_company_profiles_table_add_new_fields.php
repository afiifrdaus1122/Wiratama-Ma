<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn('vision_mission');
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('company_values')->nullable();
            $table->text('company_history')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->text('vision_mission')->nullable();
            $table->dropColumn(['vision', 'mission', 'company_values', 'company_history']);
        });
    }
};
