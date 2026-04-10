<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-info">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Recibo do Pedido: {{ $pedido->codigo }}</h4>
                    <span class="badge bg-light text-dark fs-6">{{ strtoupper(str_replace('_', ' ', $pedido->status)) }}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Cliente:</strong> {{ $pedido->nome_cliente }}</p>
                            <p class="mb-0"><strong>Data:</strong> {{ date('d/m/Y', strtotime($pedido->data_pedido)) }}</p>
                        </div>
                    </div>

                    <h5 class="border-bottom pb-2">Itens Consumidos</h5>
                    
                    {{-- Tabela listando os produtos DAQUELE pedido --}}
                    <table class="table table-sm mt-3">
                        <thead class="table-light">
                            <tr>
                                <th>Produto</th>
                                <th>Valor Unitário</th>
                                <th class="text-center">Quantidade</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Loop na relação N:M buscando os dados da tabela Pivot --}}
                            @forelse ($pedido->produtos as $produto)
                                <tr>
                                    <td>{{ $produto->nome }}</td>
                                    <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                                    <td class="text-center">{{ $produto->pivot->quantidade }}x</td>
                                    <td class="text-end">
                                        R$ {{ number_format($produto->preco * $produto->pivot->quantidade, 2, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Nenhum item registrado neste pedido.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-group-divider fw-bold">
                            <tr>
                                <td colspan="3" class="text-end fs-5">TOTAL DO PEDIDO:</td>
                                <td class="text-end fs-5 text-success">
                                    R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="mt-4 d-flex justify-content-between">
                        <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">&larr; Voltar para a lista</a>
                        <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-warning">Editar Status/Itens</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>