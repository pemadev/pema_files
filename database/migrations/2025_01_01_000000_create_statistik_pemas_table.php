<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistik_pemas', function (Blueprint $table) {
            $table->id();
            $table->string('label');                          
            $table->decimal('value', 12, 2);                  
            $table->unsignedTinyInteger('decimals')->default(0); 
            $table->string('prefix')->nullable();              
            $table->string('suffix')->nullable();              
            $table->text('deskripsi')->nullable();             
            $table->unsignedInteger('urutan')->default(0);     
            $table->boolean('is_active')->default(true);       
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistik_pemas');
    }
};