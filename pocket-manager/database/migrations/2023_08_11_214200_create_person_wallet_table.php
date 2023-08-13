<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('person_wallet')) {
            Schema::create('person_wallet', function (Blueprint $table) {
                $table->foreignUuid('person_id')->references('id')->on('people');
                $table->foreignUuid('wallet_id')->references('id')->on('wallets');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('person_wallet');
    }
};
