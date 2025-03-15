import ApiModel from "./ApiModel";
import Sign, { type SignType} from "./Sign";

export type ExampleType = {
    sign_id?: number;
    description?: string;
    display?: string;
}

export default class Example extends ApiModel<ExampleType> implements ExampleType {
    url: string = 'api/examples'

    sign_id?: number;
    description?: string;
    display?: string;
    #sign?: Sign;

    constructor(data: ExampleType) {
        super();
        this.sync(data);
    }

    get sign(): Sign | undefined {
        return this.#sign;
    }

    set sign(value: Sign | SignType) {
        this.#sign = value instanceof Sign ? value : new Sign(value);
    }
}