import type { AxiosError } from "axios";

export default defineNuxtRouteMiddleware(async (to, from) => {
    const token = useCookie('token').value;
    if(token) {
        const { $axios } = useNuxtApp();
        $axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        try {
            const { data } = await $axios.get('/api/users/is_admin');
            console.log(data);
            if(!data.is_admin) {
                return navigateTo('/');
            }
        } catch(e: AxiosError | any) {
            return navigateTo('/');
        }
    } else {
        return navigateTo('/auth/login');
    }
});