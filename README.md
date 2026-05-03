# Salas - Sistema de Reserva de Salas

Aplicacao Laravel para gerenciamento de clientes, salas e reservas.

## Requisitos

- Docker Desktop (com Docker Compose)
- Git
- (Opcional) WSL2 no Windows

## Setup e Execucao

### 1. Clonar o projeto

```bash
git clone <url-do-repositorio>
cd salas
```

### 2. Criar arquivo de ambiente

```bash
cp .env.example .env
```

### 3. Subir os containers

```bash
docker compose up -d --build
```

### 4. Instalar dependencias

```bash
docker compose exec app composer install
```

### 5. Gerar chave da aplicacao

```bash
docker compose exec app php artisan key:generate
```

### 6. Executar migrations

```bash
docker compose exec app php artisan migrate
```

### 7. Criar link do storage publico

```bash
docker compose exec app php artisan storage:link
```

### 8. Acessar no navegador

```text
http://localhost:8080
```

## Regras de Negocio

### Clientes

- Campos principais: `nome`, `documento`, `telefone`, `email`.
- `documento` e obrigatorio e unico (CPF/CNPJ).
- Cliente pode ter varias reservas.

### Salas

- Campos principais: `nome`, `capacidade`, `descricao`, `status`, `imagem`.
- Contato da loja: `responsavel_nome`, `responsavel_telefone`, `responsavel_email`.
- Localizacao: `cep`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `uf`.
- `status` permitido: `disponivel`, `indisponivel`, `manutencao`.
- Upload de imagem opcional:
  - formatos: `jpg`, `jpeg`, `png`, `webp`
  - tamanho maximo: `2MB`
- Atualizacao de imagem remove a imagem antiga do storage.
- Exclusao da sala:
  - bloqueada se houver reservas vinculadas
  - exclusao logica (soft delete)

### Reservas

- Campos principais: `cliente_id`, `sala_id`, `data_reserva`, `horario_inicio`, `horario_fim`, `status`.
- Ao criar nova reserva:
  - status sempre `pendente` automaticamente
  - confirmacao e feita manualmente na edicao
- Validacoes:
  - `horario_fim` deve ser maior que `horario_inicio`
  - cliente e sala devem existir

### Regras de Reserva

1. Um cliente pode ter somente 1 reserva por dia.
2. Um cliente pode ter no maximo 3 reservas por mes.
3. Uma sala nao pode ter conflito de horario no mesmo dia.
4. Reserva so pode ser criada para sala com status `disponivel`.

### Exclusao Logica (Soft Delete)

- Entidades com exclusao logica:
  - `clientes`
  - `salas`
  - `reservas`
- Ao excluir, o registro recebe `deleted_at` e deixa de aparecer no front.

## Recursos de Frontend Implementados

- Dashboard com vitrine de salas.
- Botao "Reservar" no dashboard abre Nova Reserva com sala pre-selecionada.
- Tela de reservas com calendario (mes/semana/dia).
- Busca responsiva nas listagens (filtra ao digitar, sem submit manual):
  - clientes
  - salas
  - reservas
- Mascaras de entrada:
  - CPF/CNPJ e telefone em clientes
  - telefone e CEP em salas
- Integracao ViaCEP para preenchimento automatico de endereco nas salas.
