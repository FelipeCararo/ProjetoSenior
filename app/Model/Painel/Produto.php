<?php

namespace App\Model\Painel;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'name', 'descricao', 'preco',
    ];

}
