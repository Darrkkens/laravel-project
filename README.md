## Subindo o projeto

1. Clonar o repositório
2. Rodar:

```
docker compose up -d --build
docker compose exec app composer install
docker compose exec app php artisan key:generate
```

3. Acessar:
http://localhost:8080
