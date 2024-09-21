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
            $table->string('dni', 45);
            $table->foreignId('id_reg')->constrained('regions');
            $table->foreignId('id_com')->constrained('communes');
            $table->string('email', 120)->unique();
            $table->string('name', 45);
            $table->string('last_name', 45);
            $table->string('address', 255)->nullable();
            $table->dateTime('date_reg');
            $table->enum('status', ['A', 'I', 'trash'])->default('A');
            $table->primary(['dni', 'id_reg', 'id_com']);
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
