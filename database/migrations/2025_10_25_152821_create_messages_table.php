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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('channel_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->json('attachments')->nullable(); // Array of file URLs
            $table->foreignId('reply_to_message_id')->nullable()->constrained('messages')->onDelete('set null');
            $table->boolean('is_edited')->default(false);
            $table->boolean('is_pinned')->default(false);
            $table->timestamp('edited_at')->nullable();
            $table->timestamps();
            $table->index(['channel_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
