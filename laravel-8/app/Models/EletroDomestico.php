<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EletroDomestico extends Model
{
    use HasFactory;

    protected $table = 'eletro_domesticos';

    protected $fillable = [
        'id',
        'nome',
        'descricao',
        'tensao',
        'preco',
        'cor',
        'created_at',
        'updated_at',
        'marca_id',
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id', 'id');
    }
}
