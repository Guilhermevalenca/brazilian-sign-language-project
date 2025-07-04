// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-03-16',
  devtools: { enabled: true },
  ssr: true,
  srcDir: 'src',
  debug: false,
  css: ['~/assets/css/main.scss'],
  routeRules: {
    '/about': { isr: true },
    '/auth/**': { isr: true },
  },
  vite: {
    css:
        {
      preprocessorOptions: {
        scss: {
          additionalData: "@use '~/assets/css/colors.scss' as *;",
        },
      },
    },
  },
  postcss: {
    plugins: {
      tailwindcss: {},
      autoprefixer: {},
    },
  },
  modules: ['@pinia/nuxt', '@nuxt/image'],
  pinia: {
    storesDirs: ['./stores/**'],
  },
  app: {
    head: {
      htmlAttrs: {
        lang: 'pt-BR',
      },
      script: [
        {
          src: '/vlibras.js',
          tagPosition: 'bodyClose'
        }
      ],
      title: 'Glossário libras',
      link: [
        { rel: 'icon', type: 'image/svg+xml', href: '/logo.svg' }
      ]
    }
  }
});