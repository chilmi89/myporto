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
         Schema::create('role_redirects', function (Blueprint $table) {
            $table->id();
            $table->string('role_name')->unique();   // nama role dari spatie
            $table->string('route_name');            // nama route tujuan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_redirects');
    }
};
