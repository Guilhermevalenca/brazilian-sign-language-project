<template>
<div class="course-card-container">
  <div class="course-card" tabindex="0" role="button">
    <NuxtImg 
      :src="image"
      :alt="'Icone do curso: ' + course?.name"
      format="webp"
    />
    <legend>{{ course?.name }}</legend>
  </div>
</div>
</template>

<script lang="ts">
import type { CourseType } from "~/types/Course";

export default defineComponent({
  name: 'CourseCard',

  props: {
    course: Object as PropType<CourseType>,
  },

  computed: {
    image(): string {
      if(!this.course?.image) {
        return '/logo.svg';
      }
      if(String(this.course?.image).startsWith('http')) {
        return String(this.course?.image);
      }
      return import.meta.env.VITE_API_URL + '/storage/' + String(this.course?.image);
    }
  }
});
</script>

<style lang="scss" scoped>
.course-card-container{
  display: grid;
  grid-template-columns: repeat(1, 3fr); /* Define 4 colunas fixas */
}
.course-card{
  display: flex;
  gap:1em;
  text-align: center;
  flex-flow: column wrap  ;
  align-content: center;
  align-items: center;
  font-size: 1em;
  width: 10em;
  cursor: pointer;
}
img{
  border-style: solid;
  border-width: 2px;
  border-color: $primary-color;
  border-radius: 10em;
  width:8em;
  height: 8em;
}
</style>