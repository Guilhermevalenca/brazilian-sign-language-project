import type { AxiosInstance } from 'axios';

export default class Service {
  public static axiosInstance(): AxiosInstance {
    const { $axios } = useNuxtApp();
    const token = useCookie('token').value;
    if (token) {
      $axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    }
    return $axios;
  }
}
