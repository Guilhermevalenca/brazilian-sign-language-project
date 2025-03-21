import ApiModel from "./ApiModel";

export type KeywordType = {
    id?: number;
    name?: string;
}

export default class Keyword extends ApiModel<KeywordType> implements KeywordType {
    id?: number;
    name?: string;

    constructor(data: KeywordType) {
        super('api/keywords');
        this.sync(data);
    }

    toJSON = () => ({
        id: this.id,
        name: this.name,
    });
}