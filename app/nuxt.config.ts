// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-03-16',
  devtools: { enabled: true },
  ssr: true,
  srcDir: 'src',
  debug: false,
  css: ['~/assets/css/main.scss'],
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
