<template>
<div class="content">
  <div class="course-card-container" tabindex="0" role="button">
    <NuxtImg
        :src="String(course?.image)"
        alt="Icone do curso"
        format="webp"
    />
    <legend>{{ course?.name }}</legend>
  </div>
  <slot/>
</div>

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
.content{
  display: grid;
  grid-auto-columns: 10em;
}
.course-card-container{
  display: flex;
  gap:1em;
  text-align: center;
  flex-flow: column wrap  ;
  align-content: center;
  align-items: center;
  font-size: 1em;
  max-width: 10em;
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