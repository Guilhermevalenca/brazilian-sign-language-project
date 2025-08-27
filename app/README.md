# Brazilian Sign Language Project - Frontend App

## Sobre o Projeto

Aplicação web frontend desenvolvida para o projeto de Glossário de Libras (Língua Brasileira de Sinais) do IFPE. Esta SPA (Single Page Application) oferece uma interface moderna e acessível para consulta, aprendizado e gestão de sinais de Libras, conectando-se à API REST para funcionalidades completas.

## Tecnologias Utilizadas

### Framework e Runtime
- **Vue.js 3** - Framework JavaScript reativo
- **Nuxt.js 3.16+** - Framework meta-framework Vue com SSR/SSG
- **TypeScript** - Superset JavaScript com tipagem estática
- **Node.js** - Runtime JavaScript

### Ferramentas de Build e Desenvolvimento
- **Vite** - Build tool e dev server
- **Nuxt DevTools** - Ferramentas de desenvolvimento
- **ESLint 9.30** - Linter JavaScript/TypeScript
- **Prettier 3.6** - Formatador de código

### Estilização e UI
- **SCSS/Sass** - Pré-processador CSS
- **Tailwind CSS 3.4** - Framework CSS utility-first
- **PostCSS** - Processador CSS
- **Autoprefixer** - Plugin PostCSS para vendor prefixes

### Estado e Dados
- **Pinia 2.3** - Store management para Vue
- **Axios 1.7** - Cliente HTTP para API calls
- **Vue Router** - Roteamento SPA

### Visualização e Interação
- **Chart.js 4.5** - Biblioteca de gráficos
- **Vue Chart.js 5.3** - Wrapper Vue para Chart.js
- **SweetAlert2 11.17** - Modais e alertas elegantes
- **VLibras** - Plugin de acessibilidade para Libras

### Acessibilidade e SEO
- **Nuxt Image** - Otimização de imagens
- **SSR/SSG** - Server-Side Rendering e Static Site Generation
- **PWA Ready** - Preparado para Progressive Web App
- **VLibras Integration** - Tradução automática para Libras

### Containerização
- **Docker** - Containerização da aplicação
- **Docker Compose** - Orquestração de serviços
- **Multi-stage builds** - Otimização de containers

## Arquitetura

### Padrões Arquiteturais
- **Component-Based Architecture** - Arquitetura baseada em componentes
- **Composition API** - API de composição Vue 3
- **Store Pattern** - Gerenciamento de estado centralizado
- **Service Layer** - Camada de serviços para API
- **Adapter Pattern** - Adaptadores para diferentes provedores

### Estrutura de Diretórios

```
app/
├── src/
│   ├── adapters/              # Adaptadores para serviços externos
│   ├── app.vue               # Componente raiz da aplicação
│   ├── error.vue             # Página de erro global
│   ├── assets/               # Assets estáticos (CSS, imagens)
│   │   └── css/
│   │       ├── main.scss     # Estilos globais principais
│   │       └── colors.scss   # Paleta de cores
│   ├── components/           # Componentes reutilizáveis
│   │   ├── ui/              # Componentes de interface básicos
│   │   ├── layout/          # Componentes de layout
│   │   ├── forms/           # Componentes de formulários
│   │   └── charts/          # Componentes de gráficos
│   ├── composables/          # Composables Vue (lógica reutilizável)
│   │   ├── useAuth.ts       # Composable de autenticação
│   │   ├── useApi.ts        # Composable para API calls
│   │   └── useMonitoring.ts # Composable para monitoramento
│   ├── layouts/              # Layouts da aplicação
│   │   ├── default.vue      # Layout padrão
│   │   ├── auth.vue         # Layout de autenticação
│   │   └── admin.vue        # Layout administrativo
│   ├── middleware/           # Middlewares de rota
│   │   ├── auth.ts          # Middleware de autenticação
│   │   └── guest.ts         # Middleware para visitantes
│   ├── pages/                # Páginas da aplicação (roteamento automático)
│   │   ├── index.vue        # Página inicial
│   │   ├── about.vue        # Sobre o projeto
│   │   ├── search.vue       # Busca de sinais
│   │   ├── profile.vue      # Perfil do usuário
│   │   ├── favorite.vue     # Sinais favoritos
│   │   ├── auth/           # Páginas de autenticação
│   │   │   ├── login.vue
│   │   │   └── register.vue
│   │   ├── sign/           # Páginas de sinais
│   │   │   ├── [id].vue    # Visualização do sinal
│   │   │   └── index.vue   # Lista de sinais
│   │   ├── course/         # Páginas de cursos
│   │   ├── subject/        # Páginas de disciplinas
│   │   ├── keyword/        # Páginas de palavras-chave
│   │   └── monitoring/     # Páginas de monitoramento
│   ├── plugins/              # Plugins Nuxt
│   │   ├── axios.client.ts  # Configuração do Axios
│   │   └── monitoring.client.ts # Plugin de monitoramento
│   ├── public/               # Arquivos públicos estáticos
│   │   ├── logo.svg         # Logo da aplicação
│   │   ├── favicon.ico      # Favicon
│   │   └── vlibras.js       # Script do VLibras
│   ├── server/               # API server-side (opcional)
│   ├── services/             # Camada de serviços
│   │   ├── Service.ts       # Classe base de serviços
│   │   ├── AuthService.ts   # Serviço de autenticação
│   │   ├── SignService.ts   # Serviço de sinais
│   │   ├── CourseService.ts # Serviço de cursos
│   │   ├── SubjectService.ts# Serviço de disciplinas
│   │   ├── KeywordService.ts# Serviço de palavras-chave
│   │   ├── UserService.ts   # Serviço de usuários
│   │   ├── ProfileService.ts # Serviço de perfil
│   │   ├── LoadingService.ts # Serviço de loading
│   │   ├── SystemSourceService.ts # Serviço de fontes do sistema
│   │   └── UserMonitoringService.ts # Serviço de monitoramento
│   ├── stores/               # Stores Pinia
│   │   ├── useBreadcrumbStore.ts # Store de breadcrumbs
│   │   └── useUserStore.ts  # Store do usuário
│   └── types/                # Definições de tipos TypeScript
│       ├── api.ts           # Tipos da API
│       ├── user.ts          # Tipos de usuário
│       ├── sign.ts          # Tipos de sinais
│       └── common.ts        # Tipos comuns
├── .dockerignore            # Ignorar arquivos no Docker
├── .env.example             # Exemplo de variáveis de ambiente
├── .gitignore               # Ignorar arquivos no Git
├── .prettierrc.json         # Configuração Prettier
├── Dockerfile               # Docker para produção
├── dev.Dockerfile           # Docker para desenvolvimento
├── docker-compose.yml       # Orquestração Docker
├── eslint.config.mjs        # Configuração ESLint
├── nuxt.config.ts           # Configuração principal Nuxt
├── package.json             # Dependências e scripts
├── tailwind.config.js       # Configuração Tailwind
└── tsconfig.json            # Configuração TypeScript
```

### Funcionalidades Principais

#### Gestão de Usuários
- **Autenticação** - Login/logout com tokens JWT
- **Registro** - Criação de conta de usuário
- **Perfil** - Gestão de dados pessoais
- **Favoritos** - Sistema de sinais favoritos

#### Gestão de Conteúdo
- **Sinais** - Visualização e busca de sinais de Libras
- **Cursos** - Navegação por cursos disponíveis
- **Disciplinas** - Organização por disciplinas
- **Palavras-chave** - Sistema de tags e categorias
- **Exemplos** - Exemplos de uso dos sinais
- **Descrições** - Descrições detalhadas

#### Funcionalidades Avançadas
- **Busca Inteligente** - Sistema de busca com filtros
- **Monitoramento** - Tracking de uso da plataforma
- **Gráficos** - Visualização de estatísticas
- **Acessibilidade** - Integração com VLibras
- **Responsividade** - Design adaptativo para todos dispositivos

### Gerenciamento de Estado

#### Pinia Stores
1. **useUserStore** - Estado do usuário logado
2. **useBreadcrumbStore** - Navegação breadcrumb
3. **useLoadingStore** - Estados de carregamento
4. **useNotificationStore** - Notificações do sistema

#### Composables
- **useAuth()** - Lógica de autenticação
- **useApi()** - Configuração de API calls
- **useMonitoring()** - Monitoramento de páginas
- **useValidation()** - Validação de formulários

## Configuração e Instalação

### Pré-requisitos
- Node.js 18+ ou superior
- NPM, Yarn ou PNPM
- API Backend rodando
- Docker e Docker Compose (opcional)

### Instalação Local

1. **Clone o repositório:**
```bash
git clone <repository-url>
cd app/
```

2. **Instale as dependências:**
```bash
# Com NPM
npm install

# Com Yarn
yarn install

# Com PNPM
pnpm install
```

3. **Configure o ambiente:**
```bash
cp .env.example .env
```

4. **Configure as variáveis de ambiente no `.env`:**
```env
NUXT_PUBLIC_API_BASE_URL=http://localhost:8000/api
NUXT_PUBLIC_APP_URL=http://localhost:3000
```

5. **Inicie o servidor de desenvolvimento:**
```bash
npm run dev
# ou
yarn dev
# ou
pnpm dev
```

6. **Acesse a aplicação:**
```
http://localhost:3000
```

### Instalação com Docker

#### Desenvolvimento
```bash
# Build e start do container de desenvolvimento
docker-compose up --build

# Ou usando o dev.Dockerfile diretamente
docker build -f dev.Dockerfile -t brazilian-sign-app-dev .
docker run -p 3000:3000 -v $(pwd):/app brazilian-sign-app-dev
```

#### Produção
```bash
# Build do container de produção
docker build -t brazilian-sign-app .
docker run -p 3000:3000 --env-file .env.prod brazilian-sign-app
```

## Configuração de Ambiente

### Variáveis de Ambiente

```env
# URLs da aplicação
NUXT_PUBLIC_API_BASE_URL=http://localhost:8000/api
NUXT_PUBLIC_APP_URL=http://localhost:3000

# Configurações de build
NUXT_SSR=true
NUXT_DEVTOOLS=false

# Configurações de segurança
NUXT_SECRET_KEY=your-secret-key-here
```

### Configuração do Nuxt

#### nuxt.config.ts - Principais Configurações
- **SSR habilitado** para SEO e performance
- **CSS pré-processado** com SCSS
- **Otimização de imagens** com @nuxt/image
- **Store management** com Pinia
- **Linting** com ESLint integrado

## Desenvolvimento

### Scripts Disponíveis

```bash
# Desenvolvimento com hot reload
npm run dev
npm run dev-host  # Expor para rede local

# Build de produção
npm run build

# Visualizar build de produção
npm run preview

# Gerar site estático
npm run generate

# Linting e formatação
npm run lint       # ESLint
npm run format     # Prettier

# Preparar ambiente Nuxt
npm run postinstall
```

### Padrões de Código

#### TypeScript
- **Strict mode** habilitado
- **Interfaces** para tipagem de dados
- **Composables** tipados
- **Props** e **emits** tipados

#### Vue 3 Composition API
```typescript
<script setup lang="ts">
// Exemplo de composable tipado
const { data, pending, error } = await $fetch<ApiResponse<Sign[]>>('/signs')

// Props tipadas
interface Props {
  signId: string
  showDetails?: boolean
}

const props = defineProps<Props>()
</script>
```

#### Estrutura de Componentes
```vue
<template>
  <!-- Template limpo e semântico -->
</template>

<script setup lang="ts">
// Lógica do componente
</script>

<style scoped lang="scss">
// Estilos componente-específicos
</style>
```

## Integração com API

### Configuração do Axios
```typescript
// plugins/axios.client.ts
export default defineNuxtPlugin(() => {
  const config = useRuntimeConfig()
  
  const $axios = $fetch.create({
    baseURL: config.public.apiBaseUrl,
    headers: {
      'Content-Type': 'application/json',
    }
  })

  return {
    provide: {
      axios: $axios
    }
  }
})
```

### Camada de Serviços
```typescript
// services/SignService.ts
export default class SignService extends Service {
  static async getAll(filters?: SignFilters): Promise<Sign[]> {
    const response = await this.axiosInstance().get('/signs', { params: filters })
    return response.data
  }

  static async getById(id: string): Promise<Sign> {
    const response = await this.axiosInstance().get(`/signs/${id}`)
    return response.data
  }
}
```

## Roteamento e Navegação

### Sistema de Rotas
- **Roteamento automático** baseado na estrutura de `pages/`
- **Rotas dinâmicas** com parâmetros
- **Middleware de autenticação** para rotas protegidas
- **Layouts** específicos por grupo de páginas

### Middleware de Autenticação
```typescript
// middleware/auth.ts
export default defineNuxtRouteMiddleware((to, from) => {
  const { isAuthenticated } = useAuth()
  
  if (!isAuthenticated.value) {
    return navigateTo('/auth/login')
  }
})
```

## Estilização e UI

### Design System
- **Tailwind CSS** para utility classes
- **SCSS** para estilos complexos
- **Variáveis CSS** para temas
- **Design responsivo** mobile-first

### Componentes Reutilizáveis
- Botões padronizados
- Formulários consistentes
- Cards informativos
- Modais e overlays
- Loading states
- Empty states

## Acessibilidade

### Recursos de Acessibilidade
- **VLibras** integrado para tradução automática
- **Semântica HTML** correta
- **ARIA labels** e roles
- **Contraste adequado** de cores
- **Navegação por teclado**
- **Screen reader friendly**

### Configuração VLibras
```html
<!-- nuxt.config.ts -->
app: {
  head: {
    script: [{
      src: '/vlibras.js',
      tagPosition: 'bodyClose'
    }]
  }
}
```

## Performance e Otimização

### Estratégias de Performance
- **Code Splitting** automático
- **Lazy Loading** de componentes
- **Image Optimization** com Nuxt Image
- **Caching** inteligente de API calls
- **Bundle Analysis** disponível

### SEO e Meta Tags
```typescript
// pages/sign/[id].vue
useSeoMeta({
  title: `${sign.value.name} - Glossário Libras`,
  description: sign.value.description,
  ogImage: sign.value.image_url,
})
```

## Monitoramento e Analytics

### Sistema de Monitoramento
```typescript
// composables/useMonitoring.ts
export const useMonitoring = () => {
  const trackPageView = (page: string) => {
    UserMonitoringService.track({
      part_of_page: page,
      action: 'page_view',
      timestamp: new Date()
    })
  }

  return { trackPageView }
}
```

## Build e Deploy

### Build de Produção
```bash
# Build estático (SSG)
npm run generate

# Build com SSR
npm run build
```

### Deploy com Docker
```dockerfile
# Dockerfile multi-stage
FROM node:18-alpine as builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

FROM node:18-alpine as runner
WORKDIR /app
COPY --from=builder /app/.output ./.output
EXPOSE 3000
CMD ["node", ".output/server/index.mjs"]
```

## Testes

### Estrutura de Testes (Planejada)
- **Vitest** para testes unitários
- **Cypress** para testes E2E
- **Testing Library** para testes de componentes

## Troubleshooting

### Problemas Comuns

1. **Erro de conexão com API**
   ```bash
   # Verificar variável de ambiente
   echo $NUXT_PUBLIC_API_BASE_URL
   ```

2. **Problemas de CORS**
   - Verificar configuração da API
   - Confirmar domínios permitidos

3. **Erro de build**
   ```bash
   # Limpar cache e node_modules
   rm -rf node_modules .nuxt
   npm install
   ```

4. **TypeScript errors**
   ```bash
   # Verificar configuração do TypeScript
   npx nuxt typecheck
   ```

### Logs de Debug
```bash
# Debug mode
DEBUG=nuxt:* npm run dev

# Logs detalhados
NUXT_DEBUG=true npm run dev
```

## Comandos Úteis

```bash
# Análise do bundle
npm run build --analyze

# Verificação de tipos
npx nuxt typecheck

# Linting com correção automática
npm run lint --fix

# Preview do build
npm run preview

# Limpar cache
rm -rf .nuxt node_modules
npm install
```

## Contribuição

### Padrões de Desenvolvimento
- **Conventional Commits** para mensagens de commit
- **Feature branches** para novas funcionalidades
- **Code review** obrigatório
- **Testes** para novas funcionalidades

### Workflow de Desenvolvimento
1. Fork do repositório
2. Criar branch feature/fix
3. Desenvolvimento com linting
4. Testes locais
5. Pull Request
6. Code Review
7. Merge após aprovação

## Links Úteis
- [Documentação Nuxt 3](https://nuxt.com/docs)
- [Vue.js 3 Guide](https://vuejs.org/guide/)
- [Pinia Documentation](https://pinia.vuejs.org/)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [TypeScript Handbook](https://www.typescriptlang.org/docs/)

---

Desenvolvido para o IFPE - Instituto Federal de Educação, Ciência e Tecnologia de Pernambuco
