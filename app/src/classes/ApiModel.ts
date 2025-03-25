import type {AxiosInstance, AxiosResponse} from "axios";

export default abstract class ApiModel<ClassType> {
	url: string;
	protected loading: boolean = false;
	protected created_at?: Date;
	protected updated_at?: Date;

	constructor(url: string) {
		this.url = url;
		return this.disableSetModificationDuringLoading();
	}

	protected sync = (data: ClassType) => {
		if(data !== null && typeof data === 'object') {
			if('created_at' in data) {
				data.created_at = new Date(String(data.created_at));
			}
			if('updated_at' in data) {
				data.updated_at = new Date(String(data.updated_at));
			}
        	Object.assign(this, data);
		}
    }

	protected async fetch(): Promise<void | boolean | AxiosResponse> {
		if(!this.url) {
			throw new Error('url não definida');
		}

		let id: number | undefined | unknown;
		if('id' in this) {
			id = this.id;
		} else {
			throw new Error('id nao definido');
		}

		const { $axios } = useNuxtApp();
		this.loading = true;
        return $axios.get(this.url + '/' + id)
            .then((res: AxiosResponse) => {
            	this.loading = false;
				this.sync(res.data);
				return res;
            })
			.finally(() => {
				this.loading = false;
			});
    }

    protected async register(): Promise<void | boolean | AxiosResponse> {
        if(!this.url) {
			throw new Error('url não definida');
		}
		this.loading = true;
		const { $axios } = useNuxtApp();
		//@ts-ignore
        return $axios.post(this.url, this as ClassType)
        	.then((res: AxiosResponse) => {
				this.loading = false;
				return res;
			})
			.finally(() => {
				this.loading = false;
			});
    }
    
    protected async update(): Promise<void | boolean | AxiosResponse> {
        if(!this.url) {
			throw new Error('url não definida');
		}
		
		let id: number | undefined | unknown;
		if('id' in this) {
			id = this.id;
		} else {
			throw new Error('id nao definido');
		}

		this.loading = true;
		const { $axios } = useNuxtApp();
		//@ts-ignore
		return $axios.put(this.url + '/' + id, this as ClassType)
			.then((res: AxiosResponse) => {
				this.loading = false;
				return res;
			})
			.finally(() => {
				this.loading = false;
			});
    }

    protected async delete(): Promise<void | boolean | AxiosResponse> {
		if(!this.url) {
			throw new Error('url não definida');
		}
	
		let id: number | undefined | unknown;
		if('id' in this) {
			id = this.id;
		} else {
			throw new Error('id nao definido');
		}
		
		this.loading = true;
		const { $axios } = useNuxtApp();
		return $axios.delete(this.url + '/' + id)
			.then((res: AxiosResponse) => {
				this.loading = false;
				return res;
			})
			.finally(() => {
				this.loading = false;
			});
    }

    protected disableSetModificationDuringLoading() {
    	return new Proxy(this, {
	    	set(target, key, value) {
	    		if(key === 'loading') {
	    			target.loading = value;
	    		}else if(!target.loading && key in target) {
	    			//@ts-ignore
	    			target[String(key)] = value;
	    		}
	    		return true;
	    	},
	    	get(target, key) {
                if(key in target) {
                    //@ts-ignore
                    return target[String(key)];
                }
                return undefined;
            }
    	});
    }
}