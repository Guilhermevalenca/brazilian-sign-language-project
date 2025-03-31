<template>
  <div class="course-card-container" tabindex="0" role="button">
    <NuxtImg 
      :src="image"
      alt="Icone do curso"
      format="webp"
    />
    <h2>{{ course?.name }}</h2>
  </div>
  <slot/>

</template>

<script lang="ts">
import CourseType from "~/classes/Course";

export default defineComponent({
  name: 'CourseCard',

  props: {
    course: Object as PropType<CourseType>,
  },

  computed: {
    image(): string {
      if(!this.course?.image) {
        return '/img/no-image.png';
      }
      if(this.course?.image.startsWith('http')) {
        return String(this.course?.image);
      }
      return import.meta.env.VITE_API_URL + '/storage/' + String(this.course?.image);
    }
  }
});
</script>

<style lang="scss" scoped>
.course-card-container{
  gap:1em;
  display: flex;
  flex-direction: column;
  align-content: center;
  align-items: center;
  font-size: 1em;
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