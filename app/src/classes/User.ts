import type { AxiosInstance, AxiosResponse } from "axios";
import ApiModel from "./ApiModel";
import Sign, { type SignType } from "./Sign";

export type UserType = {
    id?: number;
    name?: string;
    email?: string;
    password?: string;
    password_confirmation?: string;
    new_password?: string;
    new_password_confirmation?: string;
}

export default class User extends ApiModel<UserType> implements UserType {
    id?: number | undefined;
    name?: string | undefined;
    email?: string | undefined;
    password?: string | undefined;
    password_confirmation?: string | undefined;
    new_password?: string;
    new_password_confirmation?: string;
    #favorites: Sign[] = [];

    constructor(data: UserType) {
        super('api/users');
        this.sync(data);
    }

    protected override fetch = async (): Promise<void | boolean | AxiosResponse> => {
        if(!this.url) {
			throw new Error('url não definida');
		}
        const { $axios } = useNuxtApp();
        return $axios.get(this.url)
            .then((res: AxiosResponse) => {
                this.loading = false;
                this.sync(res.data);
                return res;
            })
            .finally(() => {
                this.loading = false;
            });
    }

    protected override register = async (): Promise<void | boolean | AxiosResponse> => {
        this.url = 'api/users/register';
        return super.register()
            .finally(() => {
                this.url = 'api/users';
            });
    }

    getFavorites = (): Sign[] => {
        return [...this.#favorites];
    }

    fetchFavorites = async (): Promise<boolean> => {
        let page = 0;
        let last_page = 0;
        const { $axios } = useNuxtApp();
        const fetch = async () => {
            if(page <= last_page) {
                const { data } = await $axios.get(`api/favorites`, { 
                    params: { 
                        page: ++page, 
                    }
                });
                this.#favorites.push(...data.data.map((sign: SignType) => new Sign(sign)));
                last_page = data.last_page;
                await fetch();
            }
        }
        try {
            await fetch();
            return true;
        } catch (e) {
            console.log(e);
            return false;
        }
    }

    toJSON = () => {
        return {
            ...this,
        }
    }
}