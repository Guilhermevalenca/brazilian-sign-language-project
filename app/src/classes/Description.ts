import ApiModel from "./ApiModel";
import Sign, { type SignType } from "./Sign";

export type DescriptionType = {
    sign_id?: number;
    text?: string;
    display?: string;
}

export default class Description extends ApiModel<DescriptionType> implements DescriptionType {
    sign_id?: number;
    text?: string;
    display?: string;
    #sign?: Sign;

    constructor(data: DescriptionType) {
        super('api/descriptions');
        this.sync(data);
    }

    getSign = (): Sign | undefined => {
        return this.#sign;
    }

    setSign = (value: Sign | SignType) => {
        this.#sign = value instanceof Sign ? value : new Sign(value);
    }
}