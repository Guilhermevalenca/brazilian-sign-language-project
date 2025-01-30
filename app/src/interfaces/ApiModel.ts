import type {AxiosInstance} from "axios";

export interface ApiModel<T> {
    register(axios: AxiosInstance): Promise<void | boolean>;
    fetch(axios: AxiosInstance): Promise<T | T[]>;
}