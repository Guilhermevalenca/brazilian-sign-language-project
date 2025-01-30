import type {ApiModel} from "~/interfaces/ApiModel";
import type {UserType} from "~/classes/User";
import type {AxiosInstance} from "axios";
import User from "~/classes/User";

export default class UserService implements ApiModel<UserType> {

    constructor(
        private readonly user: User
    ) {}

    async fetch(axios: AxiosInstance): Promise<UserType> {
        return axios.get('api/user')
            .then((response) => {
                this.user.sync(response.data);
                return this.user;
            })
    }

    async register(axios: AxiosInstance): Promise<void | boolean> {
        return axios.post('api/register', this.user as UserType)
            .then(res => {
                const token = res.data.token;
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
                localStorage.setItem('token', token);
                return true;
            });
    }
}