<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('statuses')) {
            Schema::create('statuses', function (Blueprint $table) {
                $table->id()->autoIncrement()->index('status_id');
                $table->char('name')->nullable(false)->index('status_name')->unique('status_name');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
