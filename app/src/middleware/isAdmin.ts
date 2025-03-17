import type { AxiosError } from "axios";

export default defineNuxtRouteMiddleware(async (to, from) => {
    const { $axios } = useNuxtApp();
    const token = useCookie('token').value;
    if(token) {
        $axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        try {
            const res = await $axios.get('/api/users/is_admin');
            if(!res.data.is_admin) {
                return navigateTo('/');
            }
        } catch(e: AxiosError | any) {
            return navigateTo('/');
        }
    } else {
        return navigateTo('/login');
    }
});