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
        // Add indexes for channels
        Schema::table('channels', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('display_order');
        });

        // Add indexes for forum topics
        Schema::table('forum_topics', function (Blueprint $table) {
            $table->index('slug');
            $table->index('category_id');
            $table->index('user_id');
            $table->index('is_pinned');
            $table->index('last_activity_at');
        });

        // Add indexes for forum posts
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->index('topic_id');
            $table->index('user_id');
            $table->index('created_at');
        });

        // Add indexes for messages
        Schema::table('messages', function (Blueprint $table) {
            $table->index('channel_id');
            $table->index('user_id');
            $table->index('created_at');
        });

        // Add indexes for recommendations
        Schema::table('recommendations', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('show_in_marquee');
            $table->index('display_order');
        });

        // Add index for users
        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('channels', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['display_order']);
        });

        Schema::table('forum_topics', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['is_pinned']);
            $table->dropIndex(['last_activity_at']);
        });

        Schema::table('forum_posts', function (Blueprint $table) {
            $table->dropIndex(['topic_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex(['channel_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('recommendations', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['show_in_marquee']);
            $table->dropIndex(['display_order']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['email']);
        });
    }
};
