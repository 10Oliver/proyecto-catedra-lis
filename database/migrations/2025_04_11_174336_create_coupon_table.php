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
        Schema::create('coupon', function (Blueprint $table) {
            $table->uuid('coupon_uuid')->primary();
            $table->string('code')->unique();
            $table->decimal('cost', 10, 2);
            $table->uuid('bill_uuid');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bill_uuid')
            ->references('bill_uuid')
            ->on('bill')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon');
    }
};
