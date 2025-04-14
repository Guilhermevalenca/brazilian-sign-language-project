import type { SignType } from "./Sign";
import type { KeywordType } from "~/types/Keyword";
import type { CourseType } from "~/types/Course";

export type SubjectType = {
    id?: number;
    name: string;
    signs?: SignType[];
    keywords?: KeywordType[];
    courses?: CourseType[];
}