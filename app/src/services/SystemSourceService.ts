import type { AxiosResponse } from "axios";
import Service from "~/services/Service";

export type FilterOptionsType = {
    courses: false,
    subjects: false,
    signs: false,
}

export default class SystemSourceService extends Service {
    static async searchAction(search: string): Promise<AxiosResponse | undefined> {
        if(search) {
            const $axios = this.axiosInstance();
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
            const $axios = this.axiosInstance();
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