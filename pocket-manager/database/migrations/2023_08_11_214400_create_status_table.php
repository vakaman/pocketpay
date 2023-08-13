<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('status')) {
            Schema::create('status', function (Blueprint $table) {
                $table->id()->autoIncrement();
                $table->char('name')->nullable(false)->index('status_name')->unique('status_name');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('status');
    }
};
