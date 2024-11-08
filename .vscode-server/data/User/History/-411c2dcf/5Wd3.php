<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
        $table->id();
        $table->string('naam');
        $table->string('soort');
        $table->decimal('loon_per_uur', 8, 2);
        $table->date('start_date');
        $table->foreignId('user_id')->constrained()->onDelete('cascade')->nullable(); // Add foreign key
        $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
