<template>
  <client-only>
    <div>
      <!-- forma 1 -->
      {{ path.pathDefault }}
    </div>
    <div>
      <!-- forma 2 -->
      {{ path.pathSecondary }}
    </div>
    <div>
      <!-- forma 3 -->
      {{ path.pathWithName }}
    </div>
    <div>
      <!-- forma 4 -->
      {{ path.pathSecondaryWithName }}
    </div>
    <div>
      <!-- forma 5 -->
      {{ path.pathTertiaryWithName }}
    </div>
    <div>
      <!-- forma 6 com array -->
       <span v-if="path.pathInArray.length === 0">/</span>
       <span v-for="(value, index) in path.pathInArray" :key="index">
        /{{ value }}
      </span>
    </div>
    <div>
      <!-- forma 7 com array -->
      <span v-if="path.pathInArrayWithName.length === 0">/</span>
      <span v-for="(value, index) in path.pathInArrayWithName" :key="index">
        /{{ value.activated }} - {{ value.name }}
      </span>
    </div>
  </client-only>
</template>

<script lang="ts">
import useBreadcrumbStore from "~/stores/useBreadcrumbStore";

export default defineComponent({
  name: "Breadcrumb",

  data: () => ({
    path: useBreadcrumbStore()
  }),

  mounted() {
    window.addEventListener("beforeunload", (event) => {
      // event.preventDefault();
      localStorage.setItem('breadcrumb', JSON.stringify({
        course: this.path.course,
        subject: this.path.subject,
        sign: this.path.sign
      }));
    });
    
    const breadcrumb = localStorage.getItem('breadcrumb');
    if (breadcrumb) {
      const parsedBreadcrumb = JSON.parse(breadcrumb);
      this.path.course = parsedBreadcrumb.course;
      this.path.subject = parsedBreadcrumb.subject;
      this.path.sign = parsedBreadcrumb.sign;
    }
  },

});
</script>

<style>

</style>