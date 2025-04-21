<template>
  <LayoutAppHeader />
  <main>
    <section>
      <LayoutBreadcrumb />
      <LayoutBackButton v-show="!isHome"/>
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
  computed:{
    isHome(){
      return useRoute().path === "/"
    }
  },

  mounted() {
    this.user = useUserStore();
  }
});
</script>

<style lang="scss" scoped>
section {
  margin: 8em auto 0 auto;
  width: 60vw;
  overflow-y: auto;
}
</style>