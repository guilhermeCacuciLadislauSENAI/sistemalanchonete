<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-success">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Cadastrar Novo Produto</h4>
                </div>
                <div class="card-body">
                    {{-- Exibe erros de validação do formulário --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('produtos.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Código Único *</label>
                                <input type="text" name="codigo" class="form-control" placeholder="Ex: HAMB-01" value="{{ old('codigo') }}" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Nome do Produto *</label>
                                <input type="text" name="nome" class="form-control" placeholder="Ex: X-Burger Duplo" value="{{ old('nome') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="descricao" class="form-control" rows="2" placeholder="Ingredientes do lanche...">{{ old('descricao') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Preço (R$) *</label>
                            {{-- Input do tipo step="0.01" para permitir centavos --}}
                            <input type="number" step="0.01" min="0" name="preco" class="form-control w-50" placeholder="Ex: 25.50" value="{{ old('preco') }}" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success px-5 fw-bold">Salvar Produto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>