# Plano de Migração: Fornecedores (Legado PHP → Laravel 12)

## 1. Análise do Legado

- Código legado procedural em PHP 7.4, tabela `fornecedores`.
- Campos: id, nome, cnpj, email, criado_em.
- Validações e regras de negócio dispersas no código.

## 2. Estratégia de Migração

- Escolha das novas tecnologias
  - Laravel 12
  - PHP 8.4
  - Docker
  - Redis

- Criar nova tabela `suppliers` em Laravel, com:
  - id (auto-incremento)
  - name, cnpj, email
  - timestamps (created_at, updated_at)
  - softDeletes (deleted_at)

- Implementar modelo Eloquent, migrations e seeds.
- Refatorar regras de negócio para Service Layer (ex: sanitização de CNPJ, transações).
- Validar dados via FormRequest (incluindo CNPJ customizado).
- Implementar endpoints RESTful equivalentes ao legado.
- Utilizar Resource para padronizar respostas JSON.
- Testar com Feature Tests (sucesso, falha, busca).

## 3. Migração de Dados

- Exportar dados do legado (ex: via dump SQL ou script).
- Adaptar campos: `nome` → `name`, `criado_em` → `created_at`.
- Importar para nova tabela `suppliers`.
- Validar unicidade de CNPJ e integridade dos dados.

## 4. Estratégia Incremental

- Manter legado e novo rodando em paralelo durante a transição.
- Redirecionar gradualmente as chamadas para a nova API.
- Garantir testes automatizados para evitar regressões.

## 5. Considerações Finais

- Toda lógica sensível (validação, transação) centralizada no Laravel.
- Uso de cache, softDeletes e validação customizada como bônus.
- Documentação e exemplos de uso no README.
- Padronização de linguagem do código.
- Implementação de otimizações para teste como Seederes e Factories.
- Implementação do Rector e Pint para estilização do código.
