import ApiModel from "./ApiModel";
import Sign, { type SignType} from "./Sign";

export type ExampleType = {
    sign_id?: number;
    description?: string;
    display?: string;
}

export default class Example extends ApiModel<ExampleType> implements ExampleType {
    sign_id?: number;
    description?: string;
    display?: string;
    #sign?: Sign;

    constructor(data: ExampleType) {
        super('api/examples');
        this.sync(data);
    }

    getSign = (): Sign | undefined => {
        return this.#sign;
    }

    setSign = (value: Sign | SignType) => {
        this.#sign = value instanceof Sign ? value : new Sign(value);
    }
}