import ApiModel from "./ApiModel";
import type Subject from "./Subject";

export type CourseType = {
    id?: number;
    name?: string;
    image?: string | File;
}

export default class Course extends ApiModel<CourseType> implements CourseType {
    id?: number;
    name?: string;
    image?: string | File;
    #subjects: Subject[] = [];

    constructor(data: CourseType) {
        super('api/courses');
        this.sync(data);
    }

    getSubjects = (): Subject[] => {
        return [...this.#subjects];
    }
    setSubjects = (value: Subject[]) => {
        this.#subjects = value;
    }
    resetSubjects = () => {
        this.#subjects = [];
    }

    toJSON = () => ({
        id: this.id,
        name: this.name,
        image: this.image,
        subjects: this.getSubjects(),
    })
}