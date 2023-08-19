<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('person_legal', function (Blueprint $table) {
            $table->foreignUuid('person_id')->references('id')->on('people');
            $table->char('document')->index('person_legal_document')->unique('person_legal_document');
            $table->char('email')->index('person_legal_email')->unique('person_legal_email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('person_legal');
    }
};
