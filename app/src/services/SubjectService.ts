import type { SubjectType } from "~/types/Subject";
export default class SubjectService {
    static async fetch(
        page: number
    ): Promise<{subjects: SubjectType[], last_page: number}> {
        const { $axios } = useNuxtApp();
        const { data: { data, last_page } } = await $axios.get('/api/subjects', {
            params: {
                page,
            }
        });
        
        return {
            subjects: data,
            last_page,
        }
    }
    static async create(subject: SubjectType) {
        const { $axios } = useNuxtApp();
        return $axios.post('/api/subjects', subject);
    }
}