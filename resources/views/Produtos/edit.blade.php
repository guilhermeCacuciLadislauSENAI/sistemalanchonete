<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-warning">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Editar Produto: {{ $produto->nome }}</h4>
                </div>
                <div class="card-body">
                    {{-- Exibe erros de validação --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Formulário de atualização via PUT --}}
                    <form action="{{ route('produtos.update', $produto->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Código Único *</label>
                                <input type="text" name="codigo" class="form-control" value="{{ old('codigo', $produto->codigo) }}" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Nome do Produto *</label>
                                <input type="text" name="nome" class="form-control" value="{{ old('nome', $produto->nome) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="descricao" class="form-control" rows="2">{{ old('descricao', $produto->descricao) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Preço (R$) *</label>
                            <input type="number" step="0.01" min="0" name="preco" class="form-control w-50" value="{{ old('preco', $produto->preco) }}" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">Voltar</a>
                            <button type="submit" class="btn btn-warning px-5 fw-bold">Atualizar Produto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>