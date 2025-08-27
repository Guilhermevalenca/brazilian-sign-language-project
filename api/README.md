# Brazilian Sign Language Project - API

## Sobre o Projeto

API REST desenvolvida para o projeto de Glossário de Libras (Língua Brasileira de Sinais) do IFPE. Esta API gerencia o backend do sistema, fornecendo endpoints para autenticação, gestão de sinais, usuários, favoritos e monitoramento de uso da plataforma.

## Tecnologias Utilizadas

### Framework e Linguagem
- **PHP 8.2+**
- **Laravel 12.0** - Framework web principal
- **Laravel Sanctum 4.0** - Autenticação e autorização via tokens

### Banco de Dados
- **MySQL/PostgreSQL** - Banco de dados principal
- **Eloquent ORM** - Mapeamento objeto-relacional

### Ferramentas de Desenvolvimento
- **Composer** - Gerenciador de dependências PHP
- **Laravel Pint** - Code style fixer
- **PHPUnit** - Testes unitários
- **Laravel Sail** - Ambiente Docker local
- **Vite** - Build tool para assets frontend

### Containerização
- **Docker** - Containerização da aplicação
- **Docker Compose** - Orquestração de serviços

## Arquitetura

### Padrões Arquiteturais
- **MVC (Model-View-Controller)**
- **Repository Pattern** (implícito via Eloquent)
- **API REST** com recursos JSON
- **Single Responsibility Principle**

### Estrutura de Diretórios

```
api/
├── app/
│   ├── Events/                 # Eventos do sistema
│   ├── Http/
│   │   ├── Controllers/        # Controladores da aplicação
│   │   │   ├── auth/          # Controladores de autenticação
│   │   │   ├── CourseController.php
│   │   │   ├── SignController.php
│   │   │   ├── UserMonitoringController.php
│   │   │   └── ...
│   │   ├── Middleware/         # Middlewares customizados
│   │   └── Requests/           # Form requests para validação
│   ├── Listeners/              # Event listeners
│   ├── Mail/                   # Classes de email
│   ├── Models/                 # Modelos Eloquent
│   │   ├── User.php
│   │   ├── Sign.php
│   │   ├── Course.php
│   │   ├── Subject.php
│   │   ├── Keyword.php
│   │   ├── Example.php
│   │   ├── Description.php
│   │   ├── Favorite.php
│   │   ├── Suggestion.php
│   │   └── UserMonitoring.php
│   ├── Policies/               # Policies de autorização
│   └── Providers/              # Service providers
├── bootstrap/                  # Arquivos de inicialização
├── config/                     # Configurações da aplicação
├── database/
│   ├── factories/              # Factories para testes
│   ├── migrations/             # Migrações do banco
│   └── seeders/               # Seeders para popular dados
├── docker/                     # Configurações Docker
│   ├── nginx.conf
│   ├── laravel.conf
│   ├── supervisor.conf
│   └── start.sh
├── lang/                       # Arquivos de internacionalização
├── public/                     # Ponto de entrada público
├── resources/                  # Views e assets
├── routes/                     # Definição de rotas
│   ├── api.php                # Rotas da API principal
│   ├── authRoute.php          # Rotas de autenticação
│   ├── signRoute.php          # Rotas de sinais
│   ├── courseRoute.php        # Rotas de cursos
│   ├── subjectRoute.php       # Rotas de disciplinas
│   ├── userRoute.php          # Rotas de usuários
│   ├── keywordRoute.php       # Rotas de palavras-chave
│   ├── favoriteRoute.php      # Rotas de favoritos
│   ├── exampleRoute.php       # Rotas de exemplos
│   ├── descriptionRoute.php   # Rotas de descrições
│   └── userMonitoring.php     # Rotas de monitoramento
├── storage/                    # Armazenamento de arquivos
├── tests/                      # Testes automatizados
└── vendor/                     # Dependências do Composer
```

### Modelos de Dados

#### Principais Entidades
1. **User** - Usuários do sistema
2. **Sign** - Sinais de libras
3. **Course** - Cursos disponíveis
4. **Subject** - Disciplinas dos cursos
5. **Keyword** - Palavras-chave dos sinais
6. **Example** - Exemplos de uso dos sinais
7. **Description** - Descrições dos sinais
8. **Favorite** - Sinais favoritos dos usuários
9. **Suggestion** - Sugestões de novos sinais
10. **UserMonitoring** - Monitoramento de uso da plataforma

### Endpoints da API

#### Autenticação (`/api/auth`)
- `POST /login` - Login do usuário
- `POST /register` - Registro de usuário
- `POST /logout` - Logout
- `GET /me` - Dados do usuário logado

#### Sinais (`/api/signs`)
- `GET /` - Listar sinais
- `GET /{id}` - Buscar sinal específico
- `POST /` - Criar novo sinal
- `PUT /{id}` - Atualizar sinal
- `DELETE /{id}` - Deletar sinal

#### Cursos (`/api/courses`)
- `GET /` - Listar cursos
- `GET /{id}` - Buscar curso específico
- `POST /` - Criar curso
- `PUT /{id}` - Atualizar curso
- `DELETE /{id}` - Deletar curso

#### Disciplinas (`/api/subjects`)
- `GET /` - Listar disciplinas
- `GET /{id}` - Buscar disciplina específica
- `POST /` - Criar disciplina
- `PUT /{id}` - Atualizar disciplina
- `DELETE /{id}` - Deletar disciplina

#### Favoritos (`/api/favorites`)
- `GET /` - Listar favoritos do usuário
- `POST /` - Adicionar aos favoritos
- `DELETE /{id}` - Remover dos favoritos

#### Palavras-chave (`/api/keywords`)
- `GET /` - Listar palavras-chave
- `POST /` - Criar palavra-chave
- `PUT /{id}` - Atualizar palavra-chave
- `DELETE /{id}` - Deletar palavra-chave

#### Monitoramento (`/api/monitoring`)
- `POST /` - Registrar evento de monitoramento
- `GET /stats` - Estatísticas de uso

## Configuração e Instalação

### Pré-requisitos
- PHP 8.2 ou superior
- Composer
- MySQL/PostgreSQL
- Node.js e NPM (para assets)
- Docker e Docker Compose (opcional)

### Instalação Local

1. **Clone o repositório:**
```bash
git clone <repository-url>
cd api/
```

2. **Instale as dependências:**
```bash
composer install
npm install
```

3. **Configure o ambiente:**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure o banco de dados no `.env`:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=brazilian_sign_language
DB_USERNAME=root
DB_PASSWORD=
```

5. **Execute as migrações:**
```bash
php artisan migrate
php artisan db:seed
```

6. **Inicie o servidor:**
```bash
php artisan serve
```

### Instalação com Docker

1. **Build e inicie os containers:**
```bash
docker-compose up -d --build
```

2. **Execute as migrações dentro do container:**
```bash
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
```

## Configuração de Ambiente

### Variáveis de Ambiente Principais

```env
APP_NAME="Brazilian Sign Language API"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=brazilian_sign_language
DB_USERNAME=root
DB_PASSWORD=

SANCTUM_STATEFUL_DOMAINS=localhost:3000
```

## Autenticação e Autorização

### Laravel Sanctum
- Sistema de autenticação baseado em tokens
- Tokens de API para SPAs
- Middleware `auth:sanctum` para rotas protegidas

### Middleware de Segurança
- CORS configurado para frontend
- Rate limiting nas rotas de API
- Validação de requests via Form Requests

## Testes

### Executar Testes
```bash
# Todos os testes
php artisan test

# Testes específicos
php artisan test --filter=SignTest

# Testes com coverage
php artisan test --coverage
```

### Estrutura de Testes
- **Feature Tests** - Testes de integração de endpoints
- **Unit Tests** - Testes unitários de models e services
- **Factories** - Geração de dados de teste

## Deployment

### Build de Produção
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Docker em Produção
```bash
docker build -t brazilian-sign-api .
docker run -d -p 80:80 --env-file .env.prod brazilian-sign-api
```

## Monitoramento e Logs

### Logs da Aplicação
- Logs armazenados em `storage/logs/`
- Diferentes níveis: debug, info, warning, error
- Configuração em `config/logging.php`

### Métricas de Performance
- UserMonitoring model para tracking de uso
- Logs de API requests
- Monitoring de erros e exceptions

## Segurança

### Principais Medidas
- Validação de input em todos endpoints
- Sanitização de dados
- Rate limiting
- HTTPS obrigatório em produção
- Tokens de autenticação seguros

### CORS
Configurado para aceitar requests do frontend em desenvolvimento e produção.

## Contribuição

### Padrões de Código
- PSR-12 para PHP
- Laravel Pint para formatação
- PHPDoc para documentação

### Workflow de Desenvolvimento
1. Fork do repositório
2. Branch feature/bugfix
3. Commits semânticos
4. Pull Request com testes
5. Code review
6. Merge após aprovação

## Comandos Úteis

```bash
# Gerar nova migração
php artisan make:migration create_table_name

# Gerar model com controller e migration
php artisan make:model ModelName -mcr

# Limpar caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Executar queues
php artisan queue:work

# Executar scheduler
php artisan schedule:work
```

## Troubleshooting

### Problemas Comuns
1. **Erro de conexão com banco** - Verificar credenciais no `.env`
2. **Token inválido** - Verificar configuração do Sanctum
3. **Permissões de arquivo** - `chmod -R 775 storage/`
4. **Memory limit** - Aumentar `memory_limit` no php.ini

### Logs de Debug
```bash
tail -f storage/logs/laravel.log
```

## Links Úteis
- [Documentação Laravel](https://laravel.com/docs)
- [Laravel Sanctum](https://laravel.com/docs/sanctum)
- [PHP PSR-12](https://www.php-fig.org/psr/psr-12/)

---

Desenvolvido para o IFPE - Instituto Federal de Educação, Ciência e Tecnologia de Pernambuco
