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
        Schema::table('recommendations', function (Blueprint $table) {
            $table->string('type')->default('stock')->after('stock_name'); // stock or option
            $table->string('option_type')->nullable()->after('type'); // call or put
            $table->decimal('strike_price', 10, 2)->nullable()->after('option_type');
            $table->date('expiration_date')->nullable()->after('strike_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recommendations', function (Blueprint $table) {
            $table->dropColumn(['type', 'option_type', 'strike_price', 'expiration_date']);
        });
    }
};
