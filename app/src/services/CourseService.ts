import { type CourseType } from "~/types/Course";

export default class CourseService {
    static async fetch(
        page: number,
    ): Promise<{courses: CourseType[], last_page: number}> {
        const { $axios } = useNuxtApp();
        const { data } = await $axios.get('/api/courses', {
            params: {
                page,
            }
        });
        
        return {
            courses: data.data as CourseType[],
            last_page: data.last_page
        }
    }

    static async create(course: CourseType) {
        const { $axios } = useNuxtApp();
        return $axios.post('/api/courses', course, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
    }

    static async find(id: number, page: number) {
        const { $axios } = useNuxtApp();
        const { data } = await $axios.get('/api/courses/' + id, {
            params: {
                page,
            }
        });
        return {
            course: {
                id: data.id,
                name: data.name,
                image: data.image,
                subjects: data.subjects.data,
            } as CourseType,
            last_page: data.subjects.last_page
        }
    }
}