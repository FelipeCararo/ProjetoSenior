<?php

namespace App\Model\Painel;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $fillable = [
        'produto_id', 'numerovenda_id'
    ];
}
