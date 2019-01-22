<?php

namespace App\Model\Painel;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $fillable = [
        'total', 'confirmado'
    ];
}
