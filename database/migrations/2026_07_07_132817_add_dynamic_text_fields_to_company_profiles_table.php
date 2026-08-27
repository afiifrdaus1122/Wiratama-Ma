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
            $table->string('contact_title')->nullable()->default('Contact Us');
            $table->string('contact_subtitle')->nullable()->default('We are ready to help you. Feel free to contact our team for product inquiries or technical support.');
            $table->string('about_page_title')->nullable()->default('Empowering Industry Through Precision');
            $table->string('about_page_subtitle')->nullable()->default('Dedicated to Your Success');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn(['contact_title', 'contact_subtitle', 'about_page_title', 'about_page_subtitle']);
        });
    }
};
