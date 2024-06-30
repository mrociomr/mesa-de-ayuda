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
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->string('nTicket')->nullable();
            $table->string('dni');
            $table->string('celular');
            $table->text('otros')->nullable();
            $table->foreignId('tipo_problema_id')->constrained('tipo_problemas')->onDelete('cascade');
            $table->foreignId('oficina_id')->constrained('oficinas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
