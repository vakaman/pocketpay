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
        if (!Schema::hasTable('transfers_status')) {
            Schema::create('transfers_status', function (Blueprint $table) {
                $table->foreignId('transfer')->references('id')->on('transfers');
                $table->char('status');
                $table->foreign('status')->references('name')->on('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers_status');
    }
};
