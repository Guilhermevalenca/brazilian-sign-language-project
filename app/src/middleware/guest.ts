import Service from "~/services/Service";

export default defineNuxtRouteMiddleware((to, from) => {
    setTimeout(async () => {
        try {
            const $axios = Service.axiosInstance();
            await $axios.get('/api/users');
            return navigateTo('/', {
                redirectCode: 301
            });
        } catch(e) {
            return;
        }
    }, 1);
});