<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    {{-- Navegação para o Cardápio --}}
    <div class="mb-4">
        <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">Gerenciar Cardápio (Produtos)</a>
    </div>

    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2>Controle de Pedidos</h2>
            <p class="text-muted">Acompanhe o andamento dos pedidos em tempo real.</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('pedidos.create') }}" class="btn btn-primary">+ Criar Novo Pedido</a>
        </div>
    </div>

    @if ($message = Session::get('sucesso'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Área de Filtros (Atendendo ao Desafio Extra) --}}
    <div class="card mb-4 shadow-sm border-0 bg-white">
        <div class="card-body d-flex justify-content-between align-items-center">
            <form action="{{ route('pedidos.index') }}" method="GET" class="d-flex w-75">
                <select name="status" class="form-select me-2 w-auto">
                    <option value="">Todos os Status</option>
                    <option value="em_preparo" {{ request('status') == 'em_preparo' ? 'selected' : '' }}>Em Preparo</option>
                    <option value="pronto" {{ request('status') == 'pronto' ? 'selected' : '' }}>Pronto</option>
                    <option value="entregue" {{ request('status') == 'entregue' ? 'selected' : '' }}>Entregue</option>
                </select>
                <button type="submit" class="btn btn-dark me-2">Filtrar</button>
                <a href="{{ route('pedidos.index') }}" class="btn btn-outline-danger">Limpar</a>
            </form>
            
            {{-- Botão para ver apenas pedidos de hoje --}}
            <form action="{{ route('pedidos.index') }}" method="GET">
                <input type="hidden" name="hoje" value="1">
                <button type="submit" class="btn btn-warning fw-bold">Apenas Pedidos de Hoje</button>
            </form>
        </div>
    </div>

    {{-- Tabela de Pedidos --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>Código</th>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Valor Total</th>
                        <th>Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pedidos as $pedido)
                        {{-- Destacar pedidos não entregues --}}
                        <tr class="{{ $pedido->status != 'entregue' ? 'table-light' : 'opacity-75' }}">
                            <td><strong>{{ $pedido->codigo }}</strong></td>
                            <td>{{ $pedido->nome_cliente }}</td>
                            <td>{{ date('d/m/Y', strtotime($pedido->data_pedido)) }}</td>
                            
                            {{-- Chamando a função automática de cálculo de total do Model --}}
                            <td class="text-success fw-bold">R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</td>
                            
                            <td>
                                {{-- Lógica visual para os status --}}
                                @if($pedido->status == 'em_preparo')
                                    <span class="badge bg-warning text-dark">Em Preparo </span>
                                @elseif($pedido->status == 'pronto')
                                    <span class="badge bg-primary">Pronto para Entrega </span>
                                @else
                                    <span class="badge bg-success">Entregue </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST">
                                    {{-- Botão Show para ver os itens --}}
                                    <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-sm btn-info text-white">Ver Itens</a>
                                    <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-sm btn-outline-dark">Alterar Status</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir este pedido?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Nenhum pedido encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>