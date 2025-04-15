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
        Schema::create('bill_coupon', function (Blueprint $table) {
            $table->uuid('bill_coupon_uuid')->primary();
            $table->uuid('coupon_uuid');
            $table->uuid('offer_uuid');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_uuid')
                ->references('company_uuid')
                ->on('company')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_coupon');
    }
};
