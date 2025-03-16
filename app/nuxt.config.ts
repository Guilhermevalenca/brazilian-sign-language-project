// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  devtools: { enabled: true },
  ssr: false,
  srcDir: 'src',
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
