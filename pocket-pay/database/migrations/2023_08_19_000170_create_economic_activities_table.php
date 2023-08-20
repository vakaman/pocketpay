<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('economic_activities', function (Blueprint $table) {
            $table->id()->index('economic_activities_id');
            $table->char('name')->index('economic_activities_name')->unique('economic_activities_name');
            $table->char('code')->index('economic_activities_code')->unique('economic_activities_code');
            $table->foreignId('type_id')->constrained('types', 'id', 'types_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('economic_activities');
    }
};
