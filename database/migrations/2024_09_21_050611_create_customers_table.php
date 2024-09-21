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
        Schema::create('customers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('last_name');
        $table->string('dni')->unique();
        $table->string('email')->unique();
        $table->string('address')->nullable();
        $table->text('description')->nullable();
        $table->foreignId('region_id')->constrained()->onDelete('restrict');
        $table->foreignId('commune_id')->constrained()->onDelete('restrict');
        $table->enum('status', ['A', 'I', 'trash'])->default('A');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
