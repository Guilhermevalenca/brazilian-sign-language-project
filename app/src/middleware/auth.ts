import type { AxiosError } from 'axios';
import Service from '~/services/Service';

export default defineNuxtRouteMiddleware((to, from) => {
  setTimeout(async () => {
    try {
      const $axios = Service.axiosInstance();
      await $axios.get('/api/users');
    } catch (e: AxiosError | any) {
      return navigateTo('/auth/login', {
        redirectCode: 301,
      });
    }
  }, 1);
});
