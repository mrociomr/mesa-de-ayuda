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
        Schema::create('solucions', function (Blueprint $table) {
            $table->id();
            $table->longText('descripcion');
            $table->enum('estado', ['Atendido', 'Rechazado']);
            $table->string('equipos');
            //$table->foreignId('equipo_id')->constrained('equipos')->onDelete('cascade');
            $table->foreignId('tipo_solucion_id')->constrained('tipo_solucions')->onDelete('cascade');
            $table->foreignId('incidencias_id')->constrained('incidencias')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solucions');
    }
};
