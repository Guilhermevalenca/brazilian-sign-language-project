<template>
  <div class="course-card-container" tabindex="0" role="button">
    <NuxtImg 
      :src="String(course?.image)" 
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