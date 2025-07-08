import type { SubjectType } from './Subject';
import type { KeywordType } from '~/types/Keyword';

export type CourseType = {
  id?: number;
  name: string;
  image: string | File;
  subjects?: SubjectType[];
  keywords?: KeywordType[];
};
