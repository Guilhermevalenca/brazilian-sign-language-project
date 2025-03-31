import ApiModel from "./ApiModel";
import type Course from "./Course";

export type SubjectType = {
    id?: number;
    name?: string;
}

export default class Subject extends ApiModel<SubjectType> implements SubjectType {
    id?: number;
    name?: string;
    #courses: Course[] = [];

    constructor(data: SubjectType) {
        super('api/subjects');
        this.sync(data);
    }

    getCourses = (): Course[] => {
        return [...this.#courses];
    }
    setCourses = (value: Course[]) => {
        this.#courses = value;
    }
    resetCourses = () => {
        this.#courses = [];
    }

    toJSON = () => ({
        id: this.id,
        name: this.name,
        courses: this.getCourses()
    })
}