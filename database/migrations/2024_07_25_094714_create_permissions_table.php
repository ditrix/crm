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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->enum('role',['admin','manager','top_manager']);
            $table->boolean('rw_own_customer')->default(false);
            $table->boolean('rw_own_deals')->default(false);
            $table->boolean('rw_own_reports')->default(false);
            $table->boolean('rw_customer')->default(false);
            $table->boolean('rw_deals')->default(false);
            $table->boolean('rw_reports')->default(false);
            $table->boolean('rw_options')->default(false);
            $table->boolean('rw_parameters')->default(false);
            $table->boolean('rw_users')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
