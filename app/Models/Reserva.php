<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reserva extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reservas';

    protected $fillable = [
        'cliente_id',
        'sala_id',
        'data_reserva',
        'horario_inicio',
        'horario_fim',
        'status',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function sala(): BelongsTo
    {
        return $this->belongsTo(Sala::class);
    }
}
