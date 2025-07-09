<template>
  <div class="course-card-container">
    <div class="course-card" tabindex="0" role="button">
      <img :src="image" :alt="'Icone do curso: ' + course?.name" />
      <legend>{{ course?.name }}</legend>
    </div>
  </div>
</template>

<script lang="ts">
import type { CourseType } from '~/types/Course';

export default defineComponent({
  name: 'CourseCard',

  props: {
    course: Object as PropType<CourseType>,
  },

  computed: {
    image(): string {
      return this.course?.image ? String(this.course.image) : '/logo.svg';
    },
  },
});
</script>

<style lang="scss" scoped>
.course-card-container {
  display: grid;
  grid-template-columns: repeat(1, 3fr); /* Define 4 colunas fixas */
}
.course-card {
  display: flex;
  gap: 1em;
  text-align: center;
  flex-flow: column wrap;
  overflow-wrap: break-word;
  word-break: break-word;
  align-content: center;
  align-items: center;
  font-size: 1em;
  width: 10em;
  cursor: pointer;
}
img {
  border-style: solid;
  border-width: 2px;
  border-color: $primary-color;
  border-radius: 10em;
  width: 8em;
  height: 8em;
}
.course-card-container:hover {
  transform: scale(1.1, 1.1);
}
</style>
