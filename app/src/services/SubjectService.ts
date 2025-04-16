import type { SubjectType } from "~/types/Subject";
import type { KeywordType } from "~/types/Keyword";
import type { CourseType } from "~/types/Course";
import Service from "~/services/Service";

export default class SubjectService extends Service {
    static async fetch(
        page: number
    ): Promise<{subjects: SubjectType[], last_page: number}> {
        const $axios = this.axiosInstance();
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
    static async create(subject: SubjectType, courses: CourseType[], keywords: KeywordType[]) {
        const $axios = this.axiosInstance();
        return $axios.post('/api/subjects', {
            ...subject,
            courses: courses.map((course: CourseType) => course.id),
            keywords: keywords.map((keyword: KeywordType) => keyword.id),
        });
    }

    static async find(id: number, page: number) {
        const $axios = this.axiosInstance();
        const { data } = await $axios.get('/api/subjects/' + id, {
            params: {
                page,
            }
        });
        return {
            subject: {
                id: data.id,
                name: data.name,
                signs: data.signs.data ?? [],
            },
            last_page: data.signs.last_page
        }
    }
}