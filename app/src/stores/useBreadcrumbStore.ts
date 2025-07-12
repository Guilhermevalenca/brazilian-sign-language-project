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
    monitoring: {
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
      this.home();
      this.search.isActive = true;
    },
    activeAbout() {
      this.home();
      this.about.isActive = true;
    },
    home() {
      this.course.isActive = false;
      this.subject.isActive = false;
      this.sign.isActive = false;
      this.search.isActive = false;
      this.about.isActive = false;
      this.monitoring.isActive = false;
    },
    activeMonitoring() {
      this.home();
      this.monitoring.isActive = true;
    },
  },
  getters: {
    path(): { name: string; path: string }[] {
      if (this.search.isActive) {
        return [
          {
            name: 'Busca',
            path: '/search',
          },
        ];
      }

      if (this.about.isActive) {
        return [
          {
            name: 'Sobre',
            path: '/about',
          },
        ];
      }

      if (this.monitoring.isActive) {
        return [
          {
            name: 'Monitoramento',
            path: '/monitoring',
          },
        ];
      }

      const result: { name: string; path: string }[] = [];

      if (this.course.isActive) {
        result.push({
          name: this.course.name,
          path: this.course.path,
        });

        if (this.subject.isActive) {
          result.push({
            name: this.subject.name,
            path: this.subject.path,
          });

          if (this.sign.isActive) {
            result.push({
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
