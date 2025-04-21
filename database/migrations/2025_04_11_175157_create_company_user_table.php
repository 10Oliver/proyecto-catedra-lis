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
        Schema::create('company_user', function (Blueprint $table) {
            $table->uuid('company_user_uuid')->primary();
            $table->uuid('company_uuid');
            $table->uuid('user_uuid')->nullable();
            $table->uuid('approved_uuid')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_uuid')
                ->references('company_uuid')
                ->on('company')
                ->onDelete('cascade');

            $table->foreign('user_uuid')
                ->references('user_uuid')
                ->on('user')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_user');
    }
};
