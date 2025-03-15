import ApiModel from "./ApiModel";
import Sign, { type SignType } from "./Sign";

export type DescriptionType = {
    sign_id?: number;
    text?: string;
    display?: string;
}

export default class Description extends ApiModel<DescriptionType> implements DescriptionType {
    url: string = 'api/descriptions';

    sign_id?: number;
    text?: string;
    display?: string;
    #sign?: Sign;

    constructor(data: DescriptionType) {
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