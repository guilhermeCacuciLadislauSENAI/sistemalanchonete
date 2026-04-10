<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    // 1. Listar produtos
    public function index()
    {
        $produtos = Produto::all();
        return view('produtos.index', compact('produtos'));
    }

    // 2. Formulário de criação
    public function create()
    {
        return view('produtos.create');
    }

    // 3. Salvar produto
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:produtos',
            'nome' => 'required',
            'preco' => 'required|numeric|min:0',
        ]);

        Produto::create($request->all());

        return redirect()->route('produtos.index')->with('sucesso', 'Produto cadastrado com sucesso!');
    }

    // 4. Formulário de edição
    public function edit(Produto $produto)
    {
        return view('produtos.edit', compact('produto'));
    }

    // 5. Atualizar produto
    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            'codigo' => 'required|unique:produtos,codigo,' . $produto->id,
            'nome' => 'required',
            'preco' => 'required|numeric|min:0',
        ]);

        $produto->update($request->all());

        return redirect()->route('produtos.index')->with('sucesso', 'Produto atualizado!');
    }

    // 6. Excluir produto
    public function destroy(Produto $produto)
    {
        $produto->delete();
        return redirect()->route('produtos.index')->with('sucesso', 'Produto removido!');
    }
}