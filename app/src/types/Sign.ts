import type { DescriptionType } from "./Description";
import type { ExampleType } from "./Example";
import type { KeywordType } from "./Keyword";

export type SignType = {
    id?: number;
    name?: string;
    display?: string;
    example?: ExampleType;
    description?: DescriptionType;
    keywords?: KeywordType[];
}
