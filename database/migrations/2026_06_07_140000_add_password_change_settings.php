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
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('force_password_change')->default(false)->after('mfa_enable');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('needs_password_change')->default(false)->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('force_password_change');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('needs_password_change');
        });
    }
};
