# API Fornecedores – Laravel 12

## Requisitos
- Docker e Docker Compose

## Subindo o ambiente
```bash
docker compose up -d --build
```
Acesse: http://localhost:9000/api/suppliers

## Variáveis de ambiente
```bash
cp .env.example .env
```

## Gerar API_KEY
```bash
php artisan key:generate
```

## Migrations e Seeders
```bash
docker compose exec app php artisan migrate
```

### (Opcional) docker compose exec app php artisan db:seed
```bash
docker compose exec app php artisan migrate
```

## Testes
```bash
docker compose exec app php artisan test
```

## Endpoints principais
- `POST   /api/suppliers` – Criar fornecedor
- `GET    /api/suppliers` – Listar/buscar fornecedores
- `GET    /api/suppliers/{id}` – Detalhar fornecedor
- `PUT    /api/suppliers/{id}` – Atualizar fornecedor
- `DELETE /api/suppliers/{id}` – Remover fornecedor

## Migração de dados
Veja `PLANO_MIGRACAO.md`.

## Código legado
Disponível na pasta `legado/` para referência.

## Observações
- Validação customizada de CNPJ
- SoftDeletes
- Service Layer e cache - Redis
- Testes automatizados
- Rector para manter padronização do código com boas práticas de estilo

## Boas práticas
- Antes de cada `git push`, o time deve executar o rector para manter os padrões

```bash
php artisan rector:run && php artisan pint
```
