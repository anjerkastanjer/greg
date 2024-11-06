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
        Schema::create('aanvragen', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->foreignId('oppasser_id')->constrained('users')->onDelete('cascade'); // De oppasser die de aanvraag verstuurt
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade'); // De eigenaar van het huisdier
            $table->foreignId('pet_id')->constrained('pets')->onDelete('cascade'); // Huisdier betrokken bij de aanvraag
            $table->enum('status', ['pending', 'accepted', 'rejected', 'geannulleerd'])->default('pending'); // Status van de aanvraag (toegevoegd geannulleerd)
            $table->timestamps(); // Created_at en updated_at timestamps
            $table->unique(['oppasser_id', 'pet_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aanvragen', function (Blueprint $table) {
            // Drop foreign key constraints first before dropping the table
            $table->dropForeign(['oppasser_id']);
            $table->dropForeign(['owner_id']);
            $table->dropForeign(['pet_id']);
        });
        
        // Drop the table after the foreign key constraints are removed
        Schema::dropIfExists('aanvragen');
    }
};