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
  // nitro: {
  //   prerender: {
  //     // components: [
  //     //   '~/components/AppLogo.vue',
  //     //   '~/components/AppCard.vue',
  //     //   '~/components/AppForm.vue',
  //     //   '~/components/AppButton.vue'
  //     // ]
  //   }
  // },
  postcss: {
    plugins: {
      tailwindcss: {},
      autoprefixer: {},
    },
  },
  modules: [
    '@pinia/nuxt',
  ],
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
          src: import.meta.env.VITE_API_URL + '/vlibras.js',
          tagPosition: 'bodyClose'
        }
      ],
      title: 'Brazilian sign language',
    }
  }
});
