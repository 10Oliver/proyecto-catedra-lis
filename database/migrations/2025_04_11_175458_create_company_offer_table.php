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
        Schema::create('company_offer', function (Blueprint $table) {
            $table->uuid('company_offer_uuid')->primary();
            $table->uuid('company_uuid');
            $table->uuid('offer_uuid');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_uuid')
                ->references('company_uuid')
                ->on('company')
                ->onDelete('cascade');

            $table->foreign('offer_uuid')
                ->references('offer_uuid')
                ->on('offer')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_offer');
    }
};
