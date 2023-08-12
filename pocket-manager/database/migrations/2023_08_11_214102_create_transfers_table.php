<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('transfers')) {
            Schema::create('transfers', function (Blueprint $table) {
                $table->id()->autoIncrement();
                $table->foreignUuid('from')->constrained('pockets', 'id');
                $table->foreignUuid('to')->constrained('pockets', 'id');
                $table->bigInteger('value')->unsigned()->nullable(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
