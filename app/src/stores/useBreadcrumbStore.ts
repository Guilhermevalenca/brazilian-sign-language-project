import { defineStore } from 'pinia'

export default defineStore('breadcrumb', {
  state: () => ({ 
    course: {
      isActive: false,
      name: '',
    },
    subject: {
      isActive: false,
      name: '',
    },
    sign: {
      isActive: false,
      name: '',
    },
   }),
  actions: {
    activeCourse(name: string = '') {
      this.course.isActive = true;
      this.course.name = name;
      
      this.subject.isActive = false;
      
      this.sign.isActive = false;
    },
    activeSubject(name: string = '') {
      this.course.isActive = true;

      this.subject.isActive = true;
      this.subject.name = name;
      
      this.sign.isActive = false;
    },
    activeSign(name: string = '') {
      this.course.isActive = true;
      
      this.subject.isActive = true;
      
      this.sign.isActive = true;
      this.sign.name = name;
    },
    home() {
      this.course.isActive = false;
      this.subject.isActive = false;
      this.sign.isActive = false;
    }
  },
  getters: {
    pathDefault(): string {
      let result: string = '/';
      if(this.course.isActive) {
        result += 'course/';
        if(this.subject.isActive) {
          result += 'subject/';
          if(this.sign.isActive) {
            result += 'sign'
          }
        }
      }
      return result;
    },
    pathSecondary(): string {
      let result: string = '/';
      if(this.course.isActive) {
        result += 'course';
        if(this.subject.isActive) {
          result += ' -> subject';
          if(this.sign.isActive) {
            result += ' -> sign'
          }
        }
      }
      return result;
    },
    pathWithName(): string {
      let result: string = '/';
      if(this.course.isActive) {
        result += 'course/' + this.course.name + '/';
        if(this.subject.isActive) {
          result += 'subject/' + this.subject.name + '/';
          if(this.sign.isActive) {
            result += 'sign/' + this.sign.name
          }
        }
      }
      return result;
    },

    pathSecondaryWithName(): string {
      let result: string = '/';
      if(this.course.isActive) {
        result += 'course: ' + this.course.name + '/';
        if(this.subject.isActive) {
          result += 'subject: ' + this.subject.name + '/';
          if(this.sign.isActive) {
            result += 'sign: ' + this.sign.name;
          }
        }
      }
      return result;
    },

    pathTertiaryWithName(): string {
      let result: string = '/';
      if(this.course.isActive) {
        result += 'course - ' + this.course.name + '/';
        if(this.subject.isActive) {
          result += 'subject - ' + this.subject.name + '/';
          if(this.sign.isActive) {
            result += 'sign - ' + this.sign.name;
          }
        }
      }
      return result;
    },
    pathInArray(): string[] {
      const result: string[] = [];
      if(this.course.isActive) {
        result.push('course');
        if(this.subject.isActive) {
          result.push('subject');
          if(this.sign.isActive) {
            result.push('sign');
          }
        }
      }
      return result;
    },
    pathInArrayWithName(): {activated: string, name: string}[] {
      const result: {activated: string, name: string}[] = [];
      if(this.course.isActive) {
        result.push({
          activated: 'course',
          name: this.course.name
        });
        if(this.subject.isActive) {
          result.push({
            activated: 'subject',
            name: this.subject.name
          });
          if(this.sign.isActive) {
            result.push({
              activated: 'sign',
              name: this.sign.name,
            });
          }
        }
      }
      return result;
    }
  }
})
