<template>
  <div class="course-card-container" tabindex="0" role="button">
    <img src="../../assets/icons/logistica-4.0.webp" alt="Icone do curso">
    <h2>Logistica</h2>
  </div>
  <slot/>

</template>

<script lang="ts">

export default{
  name: "CourseCard"
}
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