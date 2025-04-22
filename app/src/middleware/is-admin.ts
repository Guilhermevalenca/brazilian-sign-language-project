import type { AxiosError } from "axios";
import Service from "~/services/Service";

export default defineNuxtRouteMiddleware((to, from) => {
    setTimeout(async () => {
        try {
            const $axios = Service.axiosInstance();
            const { data } = await $axios.get('/api/users/is_admin');
            if(!data.is_admin) {
                return navigateTo('/', {
                    redirectCode: 301
                });
            }
        } catch(e: AxiosError | any) {
            return navigateTo('/', {
                redirectCode: 301
            });
        }
    }, 1);
});