<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('person_natural', function (Blueprint $table) {
            $table->foreignUuid('person_id')->references('id')->on('people');
            $table->string('name');
            $table->string('document')->index('person_natural_document')->unique('person_natural_document');
            $table->string('email')->index('person_natural_email')->unique('person_natural_email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('person_natural');
    }
};
