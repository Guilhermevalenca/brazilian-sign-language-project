import { type CourseType } from '~/types/Course';
import Service from '~/services/Service';
import type { KeywordType } from '~/types/Keyword';

export default class CourseService extends Service {
  static async fetch(page: number): Promise<{ courses: CourseType[]; last_page: number }> {
    const $axios = this.axiosInstance();
    const { data } = await $axios.get('/api/courses', {
      params: {
        page,
      },
    });

    return {
      courses: data.data as CourseType[],
      last_page: data.last_page,
    };
  }

  static async create(course: CourseType) {
    const $axios = this.axiosInstance();
    return $axios.post(
      '/api/courses',
      {
        ...course,
        keywords: course.keywords?.map((keyword: KeywordType) => keyword.id),
      },
      {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      },
    );
  }

  static async find(id: number, page: number) {
    const $axios = this.axiosInstance();
    const { data } = await $axios.get('/api/courses/' + id, {
      params: {
        page,
      },
    });
    return {
      course: {
        id: data.id,
        name: data.name,
        image: data.image,
        subjects: data.subjects.data,
      } as CourseType,
      last_page: data.subjects.last_page,
    };
  }

  static async edit(id: number) {
    const $axios = this.axiosInstance();
    const { data } = await $axios.get('api/courses/' + id + '/edit');
    return {
      course: {
        id: data.id,
        name: data.name,
        image: data.image,
        keywords: data.keywords ?? [],
      },
    };
  }

  static async update(course: CourseType, id: number) {
    const $axios = this.axiosInstance();

    if (typeof course.image === 'string') {
      //@ts-ignore
      delete course.image;
    }

    return $axios.post(
      '/api/courses/' + id,
      {
        ...course,
        keywords: course.keywords?.map((keyword: KeywordType) => Number(keyword.id)) ?? [],
      },
      {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      },
    );
  }

  static async delete(id: number) {
    const $axios = this.axiosInstance();
    return $axios.delete('/api/courses/' + id);
  }
}
