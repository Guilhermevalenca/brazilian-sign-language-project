<template>
  <div class="content-container">
    <div class="content-title">
      <h1>Cursos</h1>
    </div>
    <div class="index-content">
      <CourseCard
        v-for="course in courses" :key="course.id"
        :course="course"
        @click="$router.push(`/course/${course.id}`)"
      />
    </div>
    <Pagination v-model:page="page" :last-page="last_page"/>
  </div>

</template>

<script lang="ts">
import CourseService from '~/services/CourseService';
import { type CourseType } from '~/types/Course';

export default defineComponent({
  name: 'homePage',

  async setup() {
        const courses = ref<(CourseType)[]>([]);
        const page = ref(1);
        const last_page = ref(1);

        async function getCourses() {
            const data = await CourseService.fetch(page.value);
            courses.value = data.courses;
            last_page.value = data.last_page;
        }

        try {
          getCourses();
        } catch(error) {
          console.log(error);
        }

        return {
            courses,
            page,
            last_page,
            getCourses
        }
    },
    
    watch: {
        page() {
            if(this.page <= 0) {
                this.page = 1;
            }
            if(this.page > this.last_page) {
                this.page = this.last_page;
            }
            this.getCourses();
        }
    }
});
  
</script>
<style lang="scss" scoped>
.index-content{
  display: flex;
  align-self: center;
  justify-self: center;
  align-items: stretch;
  align-content: stretch;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: space-around;
  gap: 4em;
  padding: 2em;
}
</style>