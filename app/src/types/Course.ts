import type { SubjectType } from "./Subject";

export type CourseType = {
    id?: number;
    name: string;
    image: string | File;
    subjects?: SubjectType[];
}
