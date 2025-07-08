import type { SignType } from '~/types/Sign';
import Service from '~/services/Service';

export default class UserService extends Service {
  static async fetch() {
    const $axios = this.axiosInstance();
    return $axios.get('/api/users');
  }

  static async fetchFavorites(page: number) {
    let last_page = 1;
    const favorites: SignType[] = [];
    const $axios = this.axiosInstance();
    try {
      const { data } = await $axios.get(`api/favorites`, {
        params: {
          page: ++page,
        },
      });
      favorites.push(...data.data);
      last_page = data.last_page;
    } catch (e) {
      console.log(e);
    }
    return {
      favorites,
      last_page,
    };
  }
}
