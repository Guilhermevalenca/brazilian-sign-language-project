import Service from '~/services/Service';
import { UserMonitoringAdapter } from '~/adapters/UserMonitoringAdapter';
import type { Adapter } from '~/adapters/Adapter';
import type { AvgPartOfPageType, UserMonitoringDto } from '~/types/UserMonitoring';

export class UserMonitoringService extends Service {
  constructor(
    private readonly userMonitoringAdapter: Adapter<AvgPartOfPageType, UserMonitoringDto>,
  ) {
    super();
  }

  async register(path_of_page: string) {
    const $axios = this.axiosInstance();

    const body: Partial<AvgPartOfPageType> = { part_of_page: path_of_page };

    const { data } = await $axios.post(
      'api/user-monitoring',
      this.userMonitoringAdapter.toDto(body),
    );
    localStorage.setItem('token_monitoring', data.token);
  }

  async fetch() {
    const $axios = this.axiosInstance();
    const { data } = await $axios.get('/api/user-monitoring');

    return {
      avgPartOfPage: data.avgPartOfPage.map(this.userMonitoringAdapter.toType),
      // hitsPerReference: data.hitsPerReference
    };
  }
}

export default new UserMonitoringService(new UserMonitoringAdapter());
