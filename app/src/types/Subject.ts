import type { SignType } from "./Sign";

export type SubjectType = {
    id?: number;
    name: string;
    signs?: SignType[];
}