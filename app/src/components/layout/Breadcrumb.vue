<template>
  <client-only>
    <nav style="display: flex">
      <span @click="navigateTo('/')"> > Pagina inicial </span>
      <span
        v-for="(value, index) in breadcrumb.path"
        :key="index"
        @click="navigateTo(value.path)"
      >
          > {{ value.activated }} : {{ value.name }}
      </span>
    </nav>
  </client-only>
</template>

<script lang="ts">
import useBreadcrumbStore from "~/stores/useBreadcrumbStore";

export default defineComponent({
  name: "Breadcrumb",

  data: () => ({
    breadcrumb: useBreadcrumbStore()
  }),

  mounted() {
    window.addEventListener("beforeunload", (event) => {
      // event.preventDefault();
      localStorage.setItem('breadcrumb', JSON.stringify({
        course: this.breadcrumb.course,
        subject: this.breadcrumb.subject,
        sign: this.breadcrumb.sign
      }));
    });

    const breadcrumb = localStorage.getItem('breadcrumb');
    if (breadcrumb) {
      const parsedBreadcrumb = JSON.parse(breadcrumb);
      this.breadcrumb.course = parsedBreadcrumb.course;
      this.breadcrumb.subject = parsedBreadcrumb.subject;
      this.breadcrumb.sign = parsedBreadcrumb.sign;
    }
  },
});
</script>

<style>
span{
  cursor: pointer ;
}
</style>