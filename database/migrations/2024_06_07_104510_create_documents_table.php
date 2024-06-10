<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->uuid('guid');
            $table->string('document_name');
            $table->string('document_type');
            $table->string('file_path');
            $table->string('document_size');
            $table->string('document_checksum');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
