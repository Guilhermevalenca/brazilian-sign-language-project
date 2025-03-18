import type { AxiosResponse } from "axios";

export type FilterOptionsType = {
    courses: false,
    subjects: false,
    signs: false,
}

export default class SystemSourceService {
    static async searhAction(search: string): Promise<AxiosResponse | undefined> {
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
    ): Promise<AxiosResponse | undefined> {
        if(search) {
            const { $axios } = useNuxtApp();
            return $axios.post(`/api/keywords/with_filters`, {
                search,
                filterOptions
            }, {
                params: {
                    page,
                }
            });
        }
    }
} 