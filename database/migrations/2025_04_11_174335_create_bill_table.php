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
        Schema::create('bill', function (Blueprint $table) {
            $table->uuid('bill_uuid')->primary();
            $table->decimal('total', 10, 2);
            $table->integer('amount');
            $table->uuid('user_uuid');

            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('bill');
    }
};
