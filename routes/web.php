<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\PedidoController;

// Redireciona a página inicial direto para a listagem de pedidos
Route::get('/', function () {
    return redirect()->route('pedidos.index');
});

// ==========================================
// ROTAS DE PRODUTOS (CARDÁPIO)
// ==========================================
Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
Route::get('/produtos/novo', [ProdutoController::class, 'create'])->name('produtos.create'); // Sempre antes do {produto}
Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
Route::get('/produtos/{produto}/editar', [ProdutoController::class, 'edit'])->name('produtos.edit');
Route::put('/produtos/{produto}', [ProdutoController::class, 'update'])->name('produtos.update');
Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');

// ==========================================
// ROTAS DE PEDIDOS (BALCÃO)
// ==========================================
Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
Route::get('/pedidos/novo', [PedidoController::class, 'create'])->name('pedidos.create'); // Sempre antes do {pedido}
Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show'); // Tela de detalhes
Route::get('/pedidos/{pedido}/editar', [PedidoController::class, 'edit'])->name('pedidos.edit');
Route::put('/pedidos/{pedido}', [PedidoController::class, 'update'])->name('pedidos.update');
Route::delete('/pedidos/{pedido}', [PedidoController::class, 'destroy'])->name('pedidos.destroy');