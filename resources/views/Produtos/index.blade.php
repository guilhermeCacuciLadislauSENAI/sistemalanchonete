<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio - Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    {{-- Navegação Básica --}}
    <div class="mb-4">
        <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary">&larr; Ir para Pedidos</a>
    </div>

    {{-- Cabeçalho da Página --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2>Cardápio de Produtos</h2>
            <p class="text-muted">Gerencie os itens disponíveis para venda.</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('produtos.create') }}" class="btn btn-success">+ Novo Produto</a>
        </div>
    </div>

    {{-- Exibição de Mensagens de Sucesso --}}
    @if ($message = Session::get('sucesso'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tabela de Produtos --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produtos as $produto)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $produto->codigo }}</span></td>
                            <td><strong>{{ $produto->nome }}</strong></td>
                            {{-- Formatação de moeda no padrão brasileiro --}}
                            <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                            <td class="text-center">
                                <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST">
                                    <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-sm btn-outline-warning">Editar</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Nenhum produto cadastrado no cardápio.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>