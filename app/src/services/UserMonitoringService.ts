import Service from '~/services/Service';

export default class UserMonitoringService extends Service {
  static async register(path: string) {
    const $axios = this.axiosInstance();
    const { data } = await $axios.post('api/user-monitoring', {
      part_of_page: path,
      token: localStorage.getItem('token_monitoring'),
      timestamp: new Date().toISOString().slice(0, 19).replace('T', ' '),
    });
    localStorage.setItem('token_monitoring', data.token);
  }
  static async fetch() {
    const $axios = this.axiosInstance();
    const { data } = await $axios.get('/api/user-monitoring');

    console.log(data);

    return {
      avgPartOfPage: data.avgPartOfPage,
      // hitsPerReference: data.hitsPerReference
    };
  }
}
