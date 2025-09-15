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
        Schema::table('role_redirects', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->after('id')->unique()->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('role_redirects', function (Blueprint $table) {
            $table->dropColumn('role_id');
        });
    }
};
