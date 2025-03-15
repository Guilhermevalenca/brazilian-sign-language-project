import useUserStore from "~/stores/useUserStore";

export default defineNuxtRouteMiddleware((to, from) => {
    const userStore = useUserStore();
    if(!userStore.is_admin) {
        return navigateTo('/');
    }
});