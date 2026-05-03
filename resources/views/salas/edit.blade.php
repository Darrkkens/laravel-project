@extends('layouts.app')

@section('title', 'Editar Sala')

@section('content')
<h1 class="h3 mb-3">Editar Sala</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('salas.update', $sala) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $sala->nome) }}" required>
                @error('nome')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="capacidade" class="form-label">Capacidade</label>
                <input type="number" id="capacidade" name="capacidade" class="form-control @error('capacidade') is-invalid @enderror" value="{{ old('capacidade', $sala->capacidade) }}" min="1" required>
                @error('capacidade')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea id="descricao" name="descricao" class="form-control @error('descricao') is-invalid @enderror" rows="4">{{ old('descricao', $sala->descricao) }}</textarea>
                @error('descricao')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr>
            <h2 class="h5 mb-3">Contato da Loja</h2>

            <div class="mb-3">
                <label for="responsavel_nome" class="form-label">Responsável</label>
                <input type="text" id="responsavel_nome" name="responsavel_nome" class="form-control @error('responsavel_nome') is-invalid @enderror" value="{{ old('responsavel_nome', $sala->responsavel_nome) }}" required>
                @error('responsavel_nome')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="responsavel_telefone" class="form-label">Telefone do Responsável</label>
                    <input type="text" id="responsavel_telefone" name="responsavel_telefone" class="form-control @error('responsavel_telefone') is-invalid @enderror" value="{{ old('responsavel_telefone', $sala->responsavel_telefone) }}" maxlength="15" required>
                    @error('responsavel_telefone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="responsavel_email" class="form-label">E-mail do Responsável</label>
                    <input type="email" id="responsavel_email" name="responsavel_email" class="form-control @error('responsavel_email') is-invalid @enderror" value="{{ old('responsavel_email', $sala->responsavel_email) }}" required>
                    @error('responsavel_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr>
            <h2 class="h5 mb-3">Localização</h2>

            <div class="mb-3">
                <label for="cep" class="form-label">CEP</label>
                <div class="input-group">
                    <input type="text" id="cep" name="cep" class="form-control @error('cep') is-invalid @enderror" value="{{ old('cep', $sala->cep) }}" maxlength="9" required>
                    @error('cep')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <small id="cepFeedback" class="form-text text-muted"></small>
            </div>

            <div class="mb-3">
                <label for="logradouro" class="form-label">Logradouro</label>
                <input type="text" id="logradouro" name="logradouro" class="form-control @error('logradouro') is-invalid @enderror" value="{{ old('logradouro', $sala->logradouro) }}" required>
                @error('logradouro')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="numero" class="form-label">Número</label>
                    <input type="text" id="numero" name="numero" class="form-control @error('numero') is-invalid @enderror" value="{{ old('numero', $sala->numero) }}" required>
                    @error('numero')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8 mb-3">
                    <label for="complemento" class="form-label">Complemento</label>
                    <input type="text" id="complemento" name="complemento" class="form-control @error('complemento') is-invalid @enderror" value="{{ old('complemento', $sala->complemento) }}">
                    @error('complemento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="bairro" class="form-label">Bairro</label>
                    <input type="text" id="bairro" name="bairro" class="form-control @error('bairro') is-invalid @enderror" value="{{ old('bairro', $sala->bairro) }}" required>
                    @error('bairro')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" id="cidade" name="cidade" class="form-control @error('cidade') is-invalid @enderror" value="{{ old('cidade', $sala->cidade) }}" required>
                    @error('cidade')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label for="uf" class="form-label">UF</label>
                    <input type="text" id="uf" name="uf" class="form-control @error('uf') is-invalid @enderror" value="{{ old('uf', $sala->uf) }}" maxlength="2" required>
                    @error('uf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="">Selecione</option>
                    <option value="disponivel" @selected(old('status', $sala->status) === 'disponivel')>Disponível</option>
                    <option value="indisponivel" @selected(old('status', $sala->status) === 'indisponivel')>Indisponível</option>
                    <option value="manutencao" @selected(old('status', $sala->status) === 'manutencao')>Manutenção</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem</label>
                <input type="file" id="imagem" name="imagem" class="form-control @error('imagem') is-invalid @enderror" accept=".jpg,.jpeg,.png,.webp">
                @error('imagem')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @if ($sala->imagem)
                <div class="mb-3">
                    <p class="form-label mb-2">Imagem atual</p>
                    <img src="{{ asset('storage/' . $sala->imagem) }}" alt="Imagem da sala {{ $sala->nome }}" class="img-thumbnail" style="max-width: 220px;">
                </div>
            @endif

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('salas.index') }}" class="btn btn-outline-secondary">Voltar</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const cepInput = document.getElementById('cep');
    const telefoneInput = document.getElementById('responsavel_telefone');
    const ufInput = document.getElementById('uf');
    const buscarCepBtn = document.getElementById('buscarCepBtn');
    const cepFeedback = document.getElementById('cepFeedback');
    const logradouroInput = document.getElementById('logradouro');
    const complementoInput = document.getElementById('complemento');
    const bairroInput = document.getElementById('bairro');
    const cidadeInput = document.getElementById('cidade');
    let cepSearchTimer = null;
    let lastFetchedCep = '';

    function formatCep(value) {
        const digits = value.replace(/\D/g, '').slice(0, 8);
        return digits.replace(/(\d{5})(\d)/, '$1-$2');
    }

    function formatTelefone(value) {
        const digits = value.replace(/\D/g, '').slice(0, 11);

        if (digits.length <= 10) {
            return digits
                .replace(/^(\d{2})(\d)/, '($1) $2')
                .replace(/(\d{4})(\d)/, '$1-$2');
        }

        return digits
            .replace(/^(\d{2})(\d)/, '($1) $2')
            .replace(/(\d{5})(\d)/, '$1-$2');
    }

    async function buscarCep(force = false) {
        const cepDigits = cepInput.value.replace(/\D/g, '');
        cepFeedback.textContent = '';

        if (cepDigits.length !== 8) {
            if (cepDigits.length > 0) {
                cepFeedback.textContent = 'Informe um CEP válido com 8 dígitos.';
                cepFeedback.className = 'form-text text-danger';
            } else {
                cepFeedback.className = 'form-text text-muted';
            }
            lastFetchedCep = '';
            return;
        }

        if (!force && cepDigits === lastFetchedCep) {
            return;
        }

        cepFeedback.textContent = 'Consultando CEP...';
        cepFeedback.className = 'form-text text-muted';

        try {
            const response = await fetch(`https://viacep.com.br/ws/${cepDigits}/json/`);
            const data = await response.json();

            if (data.erro) {
                cepFeedback.textContent = 'CEP não encontrado.';
                cepFeedback.className = 'form-text text-danger';
                lastFetchedCep = '';
                return;
            }

            logradouroInput.value = data.logradouro || '';
            complementoInput.value = data.complemento || '';
            bairroInput.value = data.bairro || '';
            cidadeInput.value = data.localidade || '';
            ufInput.value = (data.uf || '').toUpperCase();
            lastFetchedCep = cepDigits;

            cepFeedback.textContent = 'Endereço preenchido com sucesso.';
            cepFeedback.className = 'form-text text-success';
        } catch (error) {
            cepFeedback.textContent = 'Não foi possível consultar o CEP agora.';
            cepFeedback.className = 'form-text text-danger';
            lastFetchedCep = '';
        }
    }

    cepInput.addEventListener('input', function () {
        cepInput.value = formatCep(cepInput.value);
        clearTimeout(cepSearchTimer);
        cepSearchTimer = setTimeout(function () {
            buscarCep(false);
        }, 350);
    });

    telefoneInput.addEventListener('input', function () {
        telefoneInput.value = formatTelefone(telefoneInput.value);
    });

    ufInput.addEventListener('input', function () {
        ufInput.value = ufInput.value.toUpperCase().slice(0, 2);
    });

    cepInput.addEventListener('blur', function () {
        buscarCep(true);
    });

    buscarCepBtn.addEventListener('click', function () {
        buscarCep(true);
    });

    cepInput.value = formatCep(cepInput.value);
    telefoneInput.value = formatTelefone(telefoneInput.value);
    ufInput.value = ufInput.value.toUpperCase().slice(0, 2);
    buscarCep(false);
});
</script>
@endsection
