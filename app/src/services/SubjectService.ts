import type { SubjectType } from "~/types/Subject";
import Subject from "~/types/Subject";

export default class SubjectService {
    static async fetch(
        page: number
    ): Promise<{subjects: Subject[], last_page: number}> {
        const { $axios } = useNuxtApp();
        const { data: { data, last_page } } = await $axios.get('/api/subjects', {
            params: {
                page,
            }
        });
        
        return {
            subjects: data.map((subject: SubjectType) => new Subject(subject)),
            last_page,
        }
    }
    static async create(subject: SubjectType) {
        const { $axios } = useNuxtApp();
        return $axios.post('/api/subjects', subject);
    }
}