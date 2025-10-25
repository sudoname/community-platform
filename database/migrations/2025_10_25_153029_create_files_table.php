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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('filename');
            $table->string('original_filename');
            $table->string('file_path');
            $table->string('file_type'); // image, video, document, etc.
            $table->string('mime_type');
            $table->integer('file_size'); // in bytes
            $table->string('uploadable_type')->nullable(); // Polymorphic - Message, ForumPost, etc.
            $table->unsignedBigInteger('uploadable_id')->nullable();
            $table->boolean('is_public')->default(true);
            $table->timestamps();
            $table->index(['uploadable_type', 'uploadable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
