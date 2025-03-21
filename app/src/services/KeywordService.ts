import Keyword, { type KeywordType } from "~/classes/Keyword";

export default class KeywordService {
    static async fetch(): Promise<Keyword[]> {
        const { $axios } = useNuxtApp();
        const token = useCookie('token').value;
        if(token) {
            $axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
        const { data } = await $axios.get('/api/keywords/create');
        return data.map((keyword: KeywordType) => new Keyword(keyword));
    }
}