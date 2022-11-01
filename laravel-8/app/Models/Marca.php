<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EletroDomestico;

class Marca extends Model
{
    use HasFactory;

    protected $table = 'marcas';

    protected $fillable = [
        'id',
        'nome',
        'slug',
        'created_at',
        'updated_at',
    ];

    public function eletrodomesticos()
    {
        return $this->hasMany(EletroDomestico::class, 'marca_id', 'id');
    }
}
