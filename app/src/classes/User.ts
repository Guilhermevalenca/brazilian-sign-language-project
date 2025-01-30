import type {ApiModel} from "~/interfaces/ApiModel";
import type {AxiosInstance} from "axios";

export type UserType = {
    id?: number;
    name?: string;
    email?: string;
    password?: string | undefined;
    password_confirmation?: string | undefined;
}

export default class User implements UserType {
    id?: number;
    name?: string;
    email?: string;
    password?: string | undefined;
    password_confirmation?: string | undefined;

    constructor(data: UserType) {
        this.id = data.id;
        this.name = data.name;
        this.email = data.email;
        this.password = data.password;
        this.password_confirmation = data.password_confirmation;
    }

    sync(data: UserType) {
        this.id = data.id;
        this.name = data.name;
        this.email = data.email;
        this.password = data.password;
        this.password_confirmation = data.password_confirmation;
    }
}