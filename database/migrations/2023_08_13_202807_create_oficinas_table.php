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
        Schema::create('oficinas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('abreviatura');
            $table->string('nivel');
            $table->string('prioridad');
            $table->string('password');
            $table->enum('estado', ['Activo', 'Inactivo']);
            $table->foreignId('sede_id')->constrained('sedes')->onDelete('cascade');
            $table->foreignId('dependencia_id')->constrained('dependencias')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oficinas');
    }
};
