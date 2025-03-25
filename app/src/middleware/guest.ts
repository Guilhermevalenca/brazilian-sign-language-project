export default defineNuxtRouteMiddleware((to, from) => {
    const token = useCookie('token').value;
    if(token) {
        return navigateTo('/');
    }
});