import type {UserType} from "~/classes/User";
import type {AxiosInstance} from "axios";

export default class AuthService {

    static async login(axios: AxiosInstance, user: UserType): Promise<boolean> {
        return axios.post('api/users/login', {
            email: user.email,
            password: user.password,
        })
            .then((response) => {
                const token = response.data.token;
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
                localStorage.setItem('token', token);
                
                const tokenCookie = useCookie('token');
                tokenCookie.value = token;

                return true;
            });

    }

    static async logout(axios: AxiosInstance) {
        await axios.post('api/users/logout');
        localStorage.removeItem('token');
        delete axios.defaults.headers.common['Authorization'];

        const tokenCookie = useCookie('token');
        tokenCookie.value = null;
    }
}
