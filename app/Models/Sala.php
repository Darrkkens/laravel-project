<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sala extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'salas';

    protected $fillable = [
        'nome',
        'capacidade',
        'descricao',
        'status',
        'imagem',
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
    ];

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class);
    }
}
