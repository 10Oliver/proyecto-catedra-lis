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
        Schema::create('offer', function (Blueprint $table) {
            $table->uuid('offer_uuid')->primary();
            $table->string('title');
            $table->decimal('regular_price', 10, 2);
            $table->decimal('offer_price', 10, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('amount')->nullable(); // Null means infinite
            $table->text('description');
            $table->boolean('state');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer');
    }
};
