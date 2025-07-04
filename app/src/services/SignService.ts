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
            console.log(data);
            return {
                sign: {
                    id: data.id,
                    name: data.name,
                    display: data.display,
                    description: data.description ?? {
                        sign_id: data.id,
                        text: '',
                        display: '',
                    },
                    example: data.example ?? {
                        sign_id: data.id,
                        description: '',
                        display: '',
                    },
                    keywords: data.keywords ?? [],
                    subjects: data.subjects ?? [],
                },
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
        return $axios.put('/api/signs/' + id, {
            ...sign,
            keywords: sign.keywords?.map((keyword: KeywordType) => keyword.id),
            subjects: sign.subjects?.map((subject: KeywordType) => subject.id),
        });
    }

    static async delete(id: number) {
        const $axios = this.axiosInstance();
        return $axios.delete('/api/signs/' + id);
    }
}