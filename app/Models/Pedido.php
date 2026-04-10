<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    // Liberando os campos do pedido
    protected $fillable = ['codigo', 'nome_cliente', 'data_pedido', 'status'];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class)->withPivot('quantidade')->withTimestamps();
    }

    public function getValorTotalAttribute()
    {
        $total = 0;
        foreach ($this->produtos as $produto) {
            $total += $produto->preco * $produto->pivot->quantidade;
        }
        return $total;
    }
}