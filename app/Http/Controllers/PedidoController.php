<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Http\Request;
use Carbon\Carbon; // Para trabalharmos com as datas dos filtros

class PedidoController extends Controller
{
    // 1. Listagem e Filtros (Atendendo ao Desafio Extra!)
    public function index(Request $request)
    {
        $query = Pedido::query();

        // Filtro: Exibir apenas pedidos de hoje
        if ($request->has('hoje')) {
            $query->whereDate('data_pedido', Carbon::today());
        }

        // Filtro: Por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ordenação por data (mais novos primeiro)
        $pedidos = $query->orderBy('data_pedido', 'desc')->get();

        return view('pedidos.index', compact('pedidos'));
    }

    // 2. Formulário de Novo Pedido
    public function create()
    {
        // Precisamos mandar todos os produtos para a tela, para o atendente escolher
        $produtos = Produto::all();
        return view('pedidos.create', compact('produtos'));
    }

    // 3. Salvar o Pedido e os Produtos (Relação Muitos-para-Muitos)
    public function store(Request $request)
    {
        // Validação
        $request->validate([
            'codigo' => 'required|unique:pedidos',
            'nome_cliente' => 'required',
            'data_pedido' => 'required|date',
            'produtos' => 'required|array', // Tem que escolher produtos
            'quantidades' => 'required|array',
        ]);

        // Passo A: Cria o pedido básico na tabela 'pedidos'
        $pedido = Pedido::create([
            'codigo' => $request->codigo,
            'nome_cliente' => $request->nome_cliente,
            'data_pedido' => $request->data_pedido,
            'status' => 'em_preparo', // Todo pedido nasce "em preparo"
        ]);

        // Passo B: Lógica para juntar o produto com a quantidade certa
        $produtosSync = [];
        foreach ($request->produtos as $index => $produto_id) {
            $quantidade = $request->quantidades[$index];
            
            // Só adiciona se a quantidade for maior que zero
            if ($quantidade > 0) {
                $produtosSync[$produto_id] = ['quantidade' => $quantidade];
            }
        }

        // Passo C: O comando sync() faz a mágica de salvar tudo na tabela intermediária (pedido_produto)
        $pedido->produtos()->sync($produtosSync);

        return redirect()->route('pedidos.index')->with('sucesso', 'Pedido criado com sucesso!');
    }

    // 4. Mostrar Detalhes do Pedido (Exibir os itens vinculados - Obrigatório)
    public function show(Pedido $pedido)
    {
        return view('pedidos.show', compact('pedido'));
    }

    // 5. Formulário de Edição
    public function edit(Pedido $pedido)
    {
        $produtos = Produto::all();
        return view('pedidos.edit', compact('pedido', 'produtos'));
    }

    // 6. Atualizar Pedido (Mudar Status)
    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'status' => 'required|in:em_preparo,pronto,entregue',
        ]);

        // Atualiza os dados
        $pedido->update($request->all());

        // Se o atendente mudou os produtos no form de edição, atualiza na tabela intermediária
        if ($request->has('produtos')) {
            $produtosSync = [];
            foreach ($request->produtos as $index => $produto_id) {
                $quantidade = $request->quantidades[$index];
                if ($quantidade > 0) {
                    $produtosSync[$produto_id] = ['quantidade' => $quantidade];
                }
            }
            $pedido->produtos()->sync($produtosSync);
        }

        return redirect()->route('pedidos.index')->with('sucesso', 'Pedido atualizado!');
    }

    // 7. Excluir
    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('sucesso', 'Pedido removido!');
    }
}