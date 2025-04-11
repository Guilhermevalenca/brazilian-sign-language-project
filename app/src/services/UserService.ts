import type { SignType } from "~/types/Sign";

export default class UserService {
    static async fetch() {
        const { $axios } = useNuxtApp();
        const token = useCookie('token').value;
        if(token) {
            $axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            return $axios.get('/api/users');
        }
        throw new Error('User is not logged in');
    }

    static async fetchFavorites(page: number) {
        let last_page = 1;
        const favorites: SignType[] = [];
        const { $axios } = useNuxtApp();
        try {
            const { data } = await $axios.get(`api/favorites`, { 
                params: { 
                    page: ++page, 
                }
            });
            favorites.push(...data.data);
            last_page = data.last_page;
        } catch (e) {
            console.log(e);
        }
        return {
            favorites,
            last_page
        };
    }
}