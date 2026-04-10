<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    // Esta é a linha que libera o salvamento em massa apenas para estes campos:
    protected $fillable = ['codigo', 'nome', 'descricao', 'preco'];

    // Um produto pode estar em vários pedidos
    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class)->withPivot('quantidade')->withTimestamps();
    }
}