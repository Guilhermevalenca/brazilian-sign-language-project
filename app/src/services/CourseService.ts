import Course, { type CourseType } from "~/classes/Course";

export default class CourseService {
    static async fetch(
        page: number,
    ): Promise<{courses: Course[], last_page: number}> {
        const { $axios } = useNuxtApp();
        const { data } = await $axios.get('/api/courses', {
            params: {
                page,
            }
        });
        
        return {
            courses: data.data.map((course: CourseType) => new Course(course)),
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
}