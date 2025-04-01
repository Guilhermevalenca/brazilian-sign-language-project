import type { CourseType } from "./Course";

export type SubjectType = {
    id?: number;
    name?: string;
    courses?: CourseType[];
}