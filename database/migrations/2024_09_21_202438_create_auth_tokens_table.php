<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthTokensTable extends Migration
{
    public function up()
    {
        Schema::create('auth_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('token')->unique();
            $table->timestamp('expires_at');
            $table->timestamps();

            
            $table->foreign('customer_id')->references('dni')->on('customers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('auth_tokens');
    }
}

