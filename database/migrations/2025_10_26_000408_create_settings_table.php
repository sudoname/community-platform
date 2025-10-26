<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, textarea, boolean, number, file
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            ['key' => 'site_name', 'value' => 'Investment Community', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_description', 'value' => 'Connect with investors, share strategies, and grow your wealth together', 'type' => 'textarea', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'contact_email', 'value' => 'admin@example.com', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'allow_registrations', 'value' => '1', 'type' => 'boolean', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
