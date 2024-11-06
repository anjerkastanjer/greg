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
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); // Status van de aanvraag
            $table->timestamps(); // Created_at en updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aanvragen');
    }
};
