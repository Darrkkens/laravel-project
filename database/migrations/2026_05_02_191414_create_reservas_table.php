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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('sala_id');
            $table->date('data_reserva');
            $table->time('horario_inicio');
            $table->time('horario_fim');
            $table->string('status')->default('pendente');

            $table->index('cliente_id');
            $table->index('sala_id');
            $table->index('data_reserva');

            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes')
                ->restrictOnDelete();

            $table->foreign('sala_id')
                ->references('id')
                ->on('salas')
                ->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
