---

### 2️⃣ Criar o arquivo de ambiente

```bash
cp .env.example .env
```

---

### 3️⃣ Subir os containers com Docker

```bash
docker compose up -d --build
```

Esse comando pode demorar alguns minutos na primeira execução.

---

### 4️⃣ Instalar as dependências do Laravel

```bash
docker compose exec app composer install
```

---

### 5️⃣ Gerar a chave da aplicação

```bash
docker compose exec app php artisan key:generate
```

---

```bash
docker compose exec app php artisan migrate
```


### 6️⃣ Acessar a aplicação

Abra o navegador e acesse:

```
http://localhost:8080
```

Se você visualizar a página inicial do Laravel, o ambiente está funcionando ✅

---

## 🛑 Problemas comuns

- **Docker não inicia**
  Verifique se o Docker Desktop está aberto.

- **Porta 8080 já está em uso**
  Feche outros serviços que possam estar usando essa porta
  ou avise o professor.

- **Erro de permissão em arquivos**
  Reinicie os containers:
  ```bash
  docker compose down
  docker compose up -d
  ```

---

## 📚 Observação importante

Este projeto será evoluído ao longo do semestre conforme os conteúdos da disciplina.
Não altere a estrutura do Docker sem orientação do professor.