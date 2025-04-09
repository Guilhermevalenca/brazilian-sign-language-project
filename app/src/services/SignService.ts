import type { SignType } from "~/types/Sign";

export default class SignService {
    static async fetch(page: number) {
        const { $axios } = useNuxtApp();
        const { data } = await $axios.get('/api/signs', {
            params: {
                page,
            }
        });
        return {
            signs: data.data,
            last_page: data.last_page
        }
    }

    static async create(sign: SignType) {
        const { $axios } = useNuxtApp();
        return $axios.post('/api/signs', sign);
    }

    static async find(id: number): Promise<{sign: SignType}> {
        const { $axios } = useNuxtApp();
        const { data } = await $axios.get('/api/signs/' + id); 
        return {
            sign: data,
        }
    }

    static async update(sign: SignType, id: number) {
        const { $axios } = useNuxtApp();
        return $axios.put('/api/signs/' + id, sign);
    }

    static async delete(id: number) {
        const { $axios } = useNuxtApp();
        return $axios.delete('/api/signs/' + id);
    }
}