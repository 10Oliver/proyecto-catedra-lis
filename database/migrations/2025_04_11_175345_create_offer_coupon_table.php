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
        Schema::create('offer_coupon', function (Blueprint $table) {
            $table->uuid('offer_coupon_uuid')->primary();
            $table->uuid('offer_uuid');
            $table->uuid('coupon_uuid');

            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('offer_coupon');
    }
};
