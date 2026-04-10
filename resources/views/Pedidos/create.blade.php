<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-primary">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Abrir Novo Pedido</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pedidos.store') }}" method="POST">
                        @csrf

                        <h5 class="mb-3 text-primary">Dados do Cliente</h5>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Código do Pedido *</label>
                                <input type="text" name="codigo" class="form-control" placeholder="Ex: PED-001" value="{{ old('codigo') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nome do Cliente *</label>
                                <input type="text" name="nome_cliente" class="form-control" placeholder="Nome de quem vai retirar" value="{{ old('nome_cliente') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Data do Pedido *</label>
                                <input type="date" name="data_pedido" class="form-control" value="{{ old('data_pedido', date('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <h5 class="mb-3 text-primary border-bottom pb-2">Selecione os Itens (Cardápio)</h5>
                        
                        {{-- Lista de produtos enviando Arrays (produtos[] e quantidades[]) para o Controller --}}
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produto</th>
                                        <th>Preço Unitário</th>
                                        <th style="width: 150px;">Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produtos as $produto)
                                        <tr>
                                            <td>
                                                <strong>{{ $produto->nome }}</strong>
                                                {{-- Input oculto com o ID do produto para o sync() do Controller --}}
                                                <input type="hidden" name="produtos[]" value="{{ $produto->id }}">
                                            </td>
                                            <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                                            <td>
                                                {{-- Input da quantidade (se for 0, o Controller ignora) --}}
                                                <input type="number" name="quantidades[]" class="form-control form-control-sm" value="0" min="0">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-5 fw-bold">Confirmar Pedido</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>