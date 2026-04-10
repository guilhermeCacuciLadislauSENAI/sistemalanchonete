<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-warning">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Atualizar Pedido: {{ $pedido->codigo }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4 align-items-end">
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Cliente: <strong>{{ $pedido->nome_cliente }}</strong></p>
                                <p class="mb-0 text-muted">Data: <strong>{{ date('d/m/Y', strtotime($pedido->data_pedido)) }}</strong></p>
                            </div>
                            
                            {{-- Campo vital exigido na atividade: Atualizar Status --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-danger">Status do Pedido *</label>
                                <select name="status" class="form-select border-danger">
                                    <option value="em_preparo" {{ $pedido->status == 'em_preparo' ? 'selected' : '' }}>Em Preparo</option>
                                    <option value="pronto" {{ $pedido->status == 'pronto' ? 'selected' : '' }}>Pronto para Entrega</option>
                                    <option value="entregue" {{ $pedido->status == 'entregue' ? 'selected' : '' }}>Entregue (Finalizado)</option>
                                </select>
                            </div>
                        </div>

                        <h5 class="mb-3 text-warning border-bottom pb-2">Ajustar Itens do Pedido</h5>
                        
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produto</th>
                                        <th>Preço Unitário</th>
                                        <th style="width: 150px;">Quantidade Atual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produtos as $produto)
                                        {{-- Lógica para buscar se esse produto já estava no pedido e com qual quantidade --}}
                                        @php
                                            $item_pedido = $pedido->produtos->firstWhere('id', $produto->id);
                                            $quantidade_atual = $item_pedido ? $item_pedido->pivot->quantidade : 0;
                                        @endphp
                                        <tr>
                                            <td>
                                                <strong>{{ $produto->nome }}</strong>
                                                <input type="hidden" name="produtos[]" value="{{ $produto->id }}">
                                            </td>
                                            <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                                            <td>
                                                {{-- O value já carrega a quantidade que estava salva no banco --}}
                                                <input type="number" name="quantidades[]" class="form-control form-control-sm" value="{{ $quantidade_atual }}" min="0">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary">Voltar sem Salvar</a>
                            <button type="submit" class="btn btn-warning px-5 fw-bold">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>