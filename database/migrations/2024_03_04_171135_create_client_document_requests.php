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
        Schema::create('client_document_requests', function (Blueprint $table) {
            $table->id();
            $table->string('instructions');
            $table->boolean('is_submitted')->default(false);;
            $table->boolean('is_url_opened')->default(false);;
            $table->foreignId('client_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_document_requests');
    }
};
