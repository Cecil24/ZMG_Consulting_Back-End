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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('asset_id');
            $table->string('location')->nullable();
            $table->string('employee')->nullable();
            $table->string('brand_name')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('status')->nullable();
            $table->string('imei_number')->nullable();
            $table->timestamp('model')->nullable();
            $table->timestamp('ram_size')->nullable();
            $table->timestamp('furniture_type')->nullable();
            $table->timestamp('description')->nullable();
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
        Schema::dropIfExists('assets');
    }
};
