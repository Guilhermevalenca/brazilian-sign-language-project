import { type KeywordType } from '~/types/Keyword';
import Service from '~/services/Service';

export default class KeywordService extends Service {
  static async fetch(page: number) {
    const $axios = this.axiosInstance();
    const { data } = await $axios.get('/api/keywords/create', {
      params: {
        page,
      },
    });
    return {
      keywords: data.data,
      last_page: data.last_page,
    };
  }

  static async create(keyword: KeywordType) {
    const $axios = this.axiosInstance();
    return $axios.post('/api/keywords', keyword);
  }

  static async find(id: number) {
    const $axios = this.axiosInstance();
    const { data } = await $axios.get('/api/keywords/' + id);
    return {
      keyword: data,
    };
  }

  static async update(keyword: KeywordType, id: number) {
    const $axios = this.axiosInstance();
    return $axios.put('/api/keywords/' + id, keyword);
  }
}
