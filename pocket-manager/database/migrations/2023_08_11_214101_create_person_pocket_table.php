<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('person_pocket')) {
            Schema::create('person_pocket', function (Blueprint $table) {
                $table->uuid('person');
                $table->foreignUuid('pocket')->references('id')->on('pockets');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('person_pocket');
    }
};
