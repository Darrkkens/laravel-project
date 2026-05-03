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
        Schema::table('salas', function (Blueprint $table) {
            $table->string('responsavel_nome')->nullable()->after('imagem');
            $table->string('responsavel_telefone', 20)->nullable()->after('responsavel_nome');
            $table->string('responsavel_email')->nullable()->after('responsavel_telefone');

            $table->string('cep', 9)->nullable()->after('responsavel_email');
            $table->string('logradouro')->nullable()->after('cep');
            $table->string('numero', 20)->nullable()->after('logradouro');
            $table->string('complemento')->nullable()->after('numero');
            $table->string('bairro')->nullable()->after('complemento');
            $table->string('cidade')->nullable()->after('bairro');
            $table->string('uf', 2)->nullable()->after('cidade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salas', function (Blueprint $table) {
            $table->dropColumn([
                'responsavel_nome',
                'responsavel_telefone',
                'responsavel_email',
                'cep',
                'logradouro',
                'numero',
                'complemento',
                'bairro',
                'cidade',
                'uf',
            ]);
        });
    }
};
