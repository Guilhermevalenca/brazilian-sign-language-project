<template>
  <LayoutAppHeader />
  <main>
    <section>
      <LayoutBreadcrumb />
      <slot />
    </section>
  </main>
  <LayoutAdmActions v-if="user && user.is_admin" />
  <LayoutAppFooter />
</template>

<script lang="ts">
import useUserStore from "~/stores/useUserStore";

export default defineComponent({
  name: "DefaultLayout",

  data: () => ({
    user: null as null | ReturnType<typeof useUserStore>
  }),

  mounted() {
    this.user = useUserStore();
  }
});
</script>

<style lang="scss" scoped>
section {
  margin: 0 auto;
  width: 60vw;
  margin-top: 8em;
  overflow-y: auto;
}
</style>