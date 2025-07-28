import vuetify, { transformAssetUrls } from 'vite-plugin-vuetify'
// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-03-16',
  devtools: { enabled: false },
  ssr: true,
  srcDir: 'src',
  debug: false,
  css: ['~/assets/css/main.scss'],
  routeRules: {
    '/about': { isr: true, prerender: true },
    '/auth/**': { isr: true, prerender: true },
    '/': { swr: 60 * 60 },
  },
  vite: {
    css: {
      preprocessorOptions: {
        scss: {
          additionalData: "@use '~/assets/css/colors.scss' as *;",
        },
      },
    },
    vue: {
      template: {
        transformAssetUrls,
      },
    },
    optimizeDeps: {
      include: ['vuetify'],
    },
  },
  postcss: {
    plugins: {
      tailwindcss: {},
      autoprefixer: {},
    },
  },
  modules: [
    '@pinia/nuxt',
    '@nuxt/image',
    '@nuxt/eslint',
    (_options, nuxt) => {
      nuxt.hooks.hook('vite:extendConfig', (config) => {
        // @ts-expect-error
        config.plugins.push(vuetify({ autoImport: true, styles: 'none' }))
      })
    },
  ],
  pinia: {
    storesDirs: ['./stores/**'],
  },
  build: {
    transpile: ['vuetify'],
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