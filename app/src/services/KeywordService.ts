import { type KeywordType } from "~/types/Keyword";

export default class KeywordService {
    static async fetch(): Promise<KeywordType[]> {
        const { $axios } = useNuxtApp();
        const token = useCookie('token').value;
        if(token) {
            $axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
        const { data } = await $axios.get('/api/keywords/create');
        return data;
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