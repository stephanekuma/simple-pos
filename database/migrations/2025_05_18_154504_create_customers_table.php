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
        Schema::create(table: 'customers', callback: static function (Blueprint $table): void {
            $table->id();
            $table->string(column: 'firstname', length: 20);
            $table->string(column: 'lastname', length: 20)->nullable();
            $table->string(column: 'email')->nullable();
            $table->string(column: 'phone')->nullable();
            $table->string(column: 'address')->nullable();
            $table->string(column: 'avatar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'customers');
    }
};
