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
    
    sync(data: UserType) {
        Object.assign(this, data);
    }

    override protected async register(axios: AxiosInstance): Promise<void | boolean | AxiosResponse> {
        if(!this.url) {
            throw new Error('url não definida');
        }
        return axios.post('api/register', this as UserType) as Promise<AxiosResponse>;
    }
}