<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('quotation_number')->nullable()->unique()->after('invoice_number');
            $table->date('quotation_valid_until')->nullable()->after('quotation_number');
            $table->string('quotation_file')->nullable()->after('quotation_valid_until');
            $table->text('quotation_notes')->nullable()->after('quotation_file');
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY status ENUM('pending','processing','completed','cancelled','quotation_requested','quotation_sent','negotiation','deal_won','deal_lost') NOT NULL DEFAULT 'pending'");
        }

        Schema::create('order_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('status');
            $table->text('note')->nullable();
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['order_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_status_histories');
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY status ENUM('pending','processing','completed','cancelled') NOT NULL DEFAULT 'pending'");
        }
        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique(['quotation_number']);
            $table->dropColumn(['quotation_number', 'quotation_valid_until', 'quotation_file', 'quotation_notes']);
        });
    }
};