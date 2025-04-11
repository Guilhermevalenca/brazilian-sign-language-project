import type { AxiosResponse } from "axios";
import type {SubjectType} from "~/types/Subject";
import type {SignType} from "~/types/Sign";
import type {CourseType} from "~/types/Course";

export type FilterOptionsType = {
    courses: false,
    subjects: false,
    signs: false,
}

export default class SystemSourceService {
    static async searchAction(search: string): Promise<AxiosResponse | undefined> {
        if(search) {
            const { $axios } = useNuxtApp();
            return $axios.get(`/api/keywords`, {
                params: {
                    search,
                }
            });
        }
    }

    static async searchActionWithFilter(
        search: string, 
        filterOptions: FilterOptionsType, 
        page: number
    ) {
        if(search) {
            const { $axios } = useNuxtApp();
            const { data } = await $axios.post(`/api/keywords/with_filters`, {
                search,
                filterOptions
            }, {
                params: {
                    page,
                }
            });

            console.log(data);

            return {
                courses: data.data.courses ?? [],
                subjects: data.data.subjects ?? [],
                signs: data.data.signs ?? [],
                last_page: data.last_page
            }
        }
    }
} 