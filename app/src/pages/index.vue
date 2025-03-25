<template>
  <div class="content-container">
  <div class="content-title">
    <h1>Cursos</h1>
  </div>
    <div class="index-content">
      <CourseCard/>
      <CourseCard/>
      <CourseCard/>
      <CourseCard/>
      <CourseCard/>
      <CourseCard/>
      <CourseCard/>
      <CourseCard/>
      <CourseCard/>
      <CourseCard/>
      <CourseCard/>
      <CourseCard/>
      <CourseCard/>
      <CourseCard/>
      <CourseCard/>
      <CourseCard/>
      <CourseCard/>
    </div>
  </div>
</template>

<script lang="ts">
  
import CourseCard from "~/components/courses/CourseCard.vue";

export default defineComponent({
  name: 'homePage',
  components: {CourseCard},
});
  
</script>
<style lang="scss" scoped>
.index-content{
  display: flex;
  align-self: center;
  justify-self: center;
  align-items: center;
  align-content: center;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: space-around;
  gap: 4em;
  padding: 2em;
}
</style>