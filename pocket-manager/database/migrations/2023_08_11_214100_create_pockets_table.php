<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pockets')) {
            Schema::create('pockets', function (Blueprint $table) {
                $table->uuid('id')->primary()->unique();
                $table->bigInteger('money')->unsigned()->nullable(false);
                $table->boolean('main')->nullable(false)->default(false);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pockets');
    }
};
