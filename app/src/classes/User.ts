import type { AxiosInstance, AxiosResponse } from "axios";
import ApiModel from "./ApiModel";

export type UserType = {
    id?: number;
    name?: string;
    email?: string;
    password?: string;
    password_confirmation?: string;
}

export default class User extends ApiModel<UserType> implements UserType {
    url: string = 'api/users';
   
    id?: number | undefined;
    name?: string | undefined;
    email?: string | undefined;
    password?: string | undefined;
    password_confirmation?: string | undefined;

    constructor(data: UserType) {
        super();
        this.sync(data);
    }

    protected override async register(axios: AxiosInstance): Promise<void | boolean | AxiosResponse> {
        this.url = 'api/users/register';
        return super.register(axios)
            .finally(() => {
                this.url = 'api/users';
            });
    }
}