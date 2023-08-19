<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('allowed_transfer', function (Blueprint $table) {
            $table->foreignId('from')->constrained('economic_activities', 'id');
            $table->foreignId('to')->constrained('economic_activities', 'id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('allowed_transfer');
    }
};
