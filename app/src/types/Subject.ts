import type { SignType } from "./Sign";
import type {KeywordType} from "~/types/Keyword";

export type SubjectType = {
    id?: number;
    name: string;
    signs?: SignType[];
    keywords?: KeywordType[];
}