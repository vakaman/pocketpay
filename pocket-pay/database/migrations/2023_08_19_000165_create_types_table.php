<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('types', function (Blueprint $table) {
            $table->id()->index('types_id');
            $table->char('name')->index('types_name')->unique('types_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('types');
    }
};
