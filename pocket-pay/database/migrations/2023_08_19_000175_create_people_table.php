<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->foreignId('type_id')->constrained('types', 'id', 'types_id');
            $table->foreignId('economic_activities_id')->constrained('economic_activities', 'id', 'economic_activities_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
