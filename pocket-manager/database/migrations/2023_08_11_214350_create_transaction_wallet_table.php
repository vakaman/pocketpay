<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('wallet_transaction')) {
            Schema::create('wallet_transaction', function (Blueprint $table) {
                $table->foreignUuid('wallet_id')->references('id')->on('wallets');
                $table->foreignUuid('transaction_id')->references('id')->on('transactions');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transaction');
    }
};
