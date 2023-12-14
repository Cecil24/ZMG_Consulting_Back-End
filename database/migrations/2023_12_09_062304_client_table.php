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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('client_id');
            $table->string('email')->unique();
            $table->string('contact_phone_number')->nullable();
            $table->string('services_rendered')->nullable();
            $table->string('agent_name')->nullable();
            $table->string('contact_person')->nullable();
            $table->timestamp('year_end_date')->nullable();
            $table->string('frequency')->nullable();
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->string('nature')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};