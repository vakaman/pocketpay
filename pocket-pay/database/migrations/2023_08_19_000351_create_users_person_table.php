<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_person', function (Blueprint $table) {
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignUuid('person_id')->references('id')->on('people');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_person');
    }
};
