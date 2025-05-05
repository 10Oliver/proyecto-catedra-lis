<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('company', function (Blueprint $table) {
      $table->uuid('company_uuid')->primary();
      $table->string('name');
      $table->string('nit')->unique();
      $table->text('address');
      $table->string('phone');
      $table->string('email');
      $table->enum('status', ['pendiente', 'aprobada', 'rechazada'])->default('pendiente');
      $table->decimal('percentage', 5, 2)->nullable();

      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('company');
  }
};
