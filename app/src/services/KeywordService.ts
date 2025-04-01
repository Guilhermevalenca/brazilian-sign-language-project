import { type KeywordType } from "~/types/Keyword";

export default class KeywordService {
    static async fetch(page: number) {
        const { $axios } = useNuxtApp();
        const token = useCookie('token').value;
        if(token) {
            $axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
        const { data } = await $axios.get('/api/keywords/create', {
            params: {
                page,
            }
        });
        return {
            keywords: data.data,
            last_page: data.last_page,
        };
    }

    static async create(keyword: KeywordType) {
        const { $axios } = useNuxtApp();
        const token = useCookie('token').value;
        if(token) {
            $axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
        return $axios.post('/api/keywords', keyword);
    }

    static async find(id: number) {
        const { $axios } = useNuxtApp();
        const token = useCookie('token').value;
        if(token) {
            $axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
        return $axios.get('/api/keywords/' + id);
    }

    static async update(keyword: KeywordType, id: number) {
        const { $axios } = useNuxtApp();
        const token = useCookie('token').value;
        if(token) {
            $axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
        return $axios.put('/api/keywords/' + id, keyword);
    }
}