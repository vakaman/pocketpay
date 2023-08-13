<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('transactions_status')) {
            Schema::create('transactions_status', function (Blueprint $table) {
                $table->foreignUuid('transaction_id')->references('id')->on('transactions');
                $table->foreignId('status_id')->references('id')->on('status');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions_status');
    }
};
