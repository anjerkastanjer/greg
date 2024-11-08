<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('oppasser', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to users table
            $table->string('naam');
            $table->json('soort_dier'); 
            $table->decimal('loon', 8, 2);
            $table->string('profile_image')->nullable();
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::table('oppassers', function (Blueprint $table) {
            $table->dropColumn('profile_image'); 
        });
        
        Schema::dropIfExists('oppasser');
    }
};