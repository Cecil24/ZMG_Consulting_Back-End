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
        Schema::table('clients', function (Blueprint $table) {
            // Add your changes here
            $table->string('vat')->nullable();
            $table->string('paye')->nullable();
            $table->string('customs')->nullable();
            $table->string('income_tax')->nullable();
            // $table->dropColumn('old_column');
            // $table->renameColumn('old_name', 'new_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // Reverse your changes here
            $table->dropColumn('vat');
            $table->dropColumn('paye');
            $table->dropColumn('customs');
            $table->dropColumn('income_tax');
            // $table->string('old_column')->nullable();
            // $table->renameColumn('new_name', 'old_name');
        });
    }
};
