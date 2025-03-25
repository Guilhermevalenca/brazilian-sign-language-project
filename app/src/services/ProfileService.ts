import type { UserType } from "~/classes/User";

export default class ProfileService {
    static async updateProfile(user: UserType) {
        const { $axios } = useNuxtApp();

        return $axios.put('/api/users', {
            name: user.name,
            email: user.email,
        });
    }

    static async updatePassword(user: UserType) {
        const { $axios } = useNuxtApp();

        return $axios.put('/api/users/password', {
            password: user.password,
            new_password: user.new_password,
            new_password_confirmation: user.new_password_confirmation
        });
    }

    static async deleteAccount(password: string) {
        const { $axios } = useNuxtApp();

        return $axios.delete('/api/users', {
            data: {
                password,
            }
        });
    }
}