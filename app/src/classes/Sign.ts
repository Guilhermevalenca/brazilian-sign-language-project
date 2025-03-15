import ApiModel from "./ApiModel";
import Description, { type DescriptionType } from "./Description";
import Example, { type ExampleType } from "./Example";

export type SignType = {
    id?: number;
    name?: string;
    display?: string;
}

export default class Sign extends ApiModel<SignType> implements SignType {
    id?: number;
    name?: string;
    display?: string;
    #example?: Example;
    #description?: Description;

    constructor(data: SignType) {
        super('api/signs');
        this.sync(data);
    }

    getExample = (): Example | undefined => {
        return this.#example;
    }

    setExample = (value?: Example | ExampleType) => {
        if(value) {
            this.#example = value instanceof Example ? value : new Example(value);
        } else {
            this.#example = new Example({
                description: '',
                display: ''
            });
        }
    }

    resetExample = () => {
        this.#example = undefined;
    }

    getDescription = (): Description | undefined => {
        return this.#description;
    }

    setDescription = (value?: Description | DescriptionType) => {
        if(value) {
            this.#description = value instanceof Description ? value : new Description(value);
        } else {
            this.#description = new Description({
                text: '',
                display: ''
            });
        }
    }

    resetDescription = () => {
        this.#description = undefined;
    }

    toJSON = () => {
        return {
            ...this,
            description: this.getDescription(),
            example: this.getExample()
        }
    }
}