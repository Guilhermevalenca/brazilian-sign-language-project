import type {AxiosInstance, AxiosResponse} from "axios";

export default abstract class ApiModel<ClassType> {
	abstract url: string;

	abstract sync(data: ClassType): void;

	protected async fetch(axios: AxiosInstance): Promise<void | boolean | AxiosResponse> {
		if(!this.url) {
			throw new Error('url não definida');
		}
        return axios.get(this.url)
            .then((res: AxiosResponse) => {
				this.sync(res.data);
            });
    }

    protected async register(axios: AxiosInstance): Promise<void | boolean | AxiosResponse> {
        if(!this.url) {
			throw new Error('url não definida');
		}
        return axios.post(this.url, this as ClassType) as Promise<AxiosResponse>;
    }
    
    protected async update(): Promise<void | boolean | AxiosResponse> {
        throw new Error('Método não implementado!');
    }

    protected async delete(): Promise<void | boolean | AxiosResponse> {
        throw new Error('Método não implementado!');
    }
}