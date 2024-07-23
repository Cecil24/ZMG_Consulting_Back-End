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
        Schema::table('client_document_requests', function (Blueprint $table) {
            // Add your changes here
            $table->integer('created_by')->nullable();
            // $table->dropColumn('old_column');
            // $table->renameColumn('old_name', 'new_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_documents', function (Blueprint $table) {
            // Reverse your changes here
            $table->dropColumn('created_by');
            // $table->string('old_column')->nullable();
            // $table->renameColumn('new_name', 'old_name');
        });
    }
};
