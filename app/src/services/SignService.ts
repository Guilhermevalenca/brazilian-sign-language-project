import type { SignType } from "~/types/Sign";
import type { KeywordType } from "~/types/Keyword";
import Service from "~/services/Service";

export default class SignService extends Service {
    static async fetch(page: number) {
        const $axios = this.axiosInstance();
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
        const $axios = this.axiosInstance();
        return $axios.post('/api/signs', {
            ...sign,
            keywords: sign.keywords?.map((keyword: KeywordType) => keyword.id),
            subjects: sign.subjects?.map((subject: KeywordType) => subject.id),
        });
    }

    static async find(id: number, isEdit: boolean = false): Promise<{sign: SignType}> {
        const $axios = this.axiosInstance();
        if(isEdit) {
            const { data } = await $axios.get('/api/signs/' + id + '/edit');
            return {
                sign: data,
            }
        } else {
            const { data } = await $axios.get('/api/signs/' + id);
            return {
                sign: data,
            }
        }
    }

    static async update(sign: SignType, id: number) {
        const $axios = this.axiosInstance();
        return $axios.put('/api/signs/' + id, sign);
    }

    static async delete(id: number) {
        const $axios = this.axiosInstance();
        return $axios.delete('/api/signs/' + id);
    }
}