import type { AxiosInstance } from "axios";
import { defineStore } from "pinia";
import User from "~/classes/User";

export default defineStore("user", {
    state: () => ({
        data: new User({
            name: '',
            email: '',
        }),
        is_admin: false,
    }),

    actions: {
        async fetchIsAdmin(axios: AxiosInstance) {
            const { data } = await axios.get('/api/users/is_admin');
            this.is_admin = data.is_admin;
            console.log('updated: is_admin');
            setTimeout(() => {
                this.fetchIsAdmin(axios);
            }, 5 * 60 * 1000);
        },
        resetDatas() {
            this.data = new User({
                name: '',
                email: '',
            });
            this.is_admin = false;
        }
    },
});