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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            // $table->string('barcode')->unique();
            $table->decimal('regular_price', 14, 2)->nullable();
            $table->decimal('price', 14, 2);
            // $table->integer('quantity')->default('1');
            $table->decimal('tax', 8, 2)->default('0.00');
            $table->boolean('is_custom_product')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
