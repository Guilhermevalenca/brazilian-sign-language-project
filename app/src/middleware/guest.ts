export default defineNuxtRouteMiddleware(async (to, from) => {
    const token = useCookie('token').value;
    if(token) {
        const { $axios } = useNuxtApp();
        $axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        try {
            await $axios.get('/api/users');
            return navigateTo('/');
        } catch(e) {
            return;
        }
    }
});