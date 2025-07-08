import { defineStore } from 'pinia';

export default defineStore('breadcrumb', {
  state: () => ({
    course: {
      isActive: false,
      name: '',
      path: '',
    },
    subject: {
      isActive: false,
      name: '',
      path: '',
    },
    sign: {
      isActive: false,
      name: '',
      path: '',
    },
    search: {
      isActive: false,
    },
    about: {
      isActive: false,
    },
  }),
  actions: {
    activeCourse(name: string = '', path: string) {
      this.course.isActive = true;
      this.course.name = name;
      this.course.path = path;

      this.subject.isActive = false;
      this.sign.isActive = false;
      this.search.isActive = false;
    },
    activeSubject(name: string = '', path: string) {
      this.subject.isActive = true;
      this.subject.name = name;
      this.subject.path = path;

      this.course.isActive = true;
      this.sign.isActive = false;
      this.search.isActive = false;
    },
    activeSign(name: string = '', path: string) {
      this.sign.isActive = true;
      this.sign.name = name;
      this.sign.path = path;

      this.course.isActive = true;
      this.subject.isActive = true;
      this.search.isActive = false;
    },
    activeSearch() {
      this.search.isActive = true;
    },
    activeAbout() {
      this.about.isActive = true;
    },
    home() {
      this.course.isActive = false;
      this.subject.isActive = false;
      this.sign.isActive = false;
      this.search.isActive = false;
      this.about.isActive = false;
    },
  },
  getters: {
    path(): { activated: string; name: string; path: string }[] {
      if (this.search.isActive) {
        return [
          {
            activated: 'Busca',
            name: '',
            path: '/search',
          },
        ];
      }

      if (this.about.isActive) {
        return [
          {
            activated: 'Sobre',
            name: '',
            path: '/about',
          },
        ];
      }

      const result: { activated: string; name: string; path: string }[] = [];

      if (this.course.isActive) {
        result.push({
          activated: 'Curso',
          name: this.course.name,
          path: this.course.path,
        });

        if (this.subject.isActive) {
          result.push({
            activated: 'Disciplina',
            name: this.subject.name,
            path: this.subject.path,
          });

          if (this.sign.isActive) {
            result.push({
              activated: 'Sinal',
              name: this.sign.name,
              path: this.sign.path,
            });
          }
        }
      }
      return result;
    },
  },
});
