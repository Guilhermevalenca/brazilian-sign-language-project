import type { AxiosError } from "axios";

export default defineNuxtRouteMiddleware(async (to, from) => {
    const { $axios } = useNuxtApp();
    const token = useCookie('token').value;
    if(token) {
        $axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

        try {
            await $axios.get('/api/users');
        } catch (e: AxiosError | any) {
            return navigateTo('/auth/login');
        }
    } else {
        return navigateTo('/auth/login');
    }
});