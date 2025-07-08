<template>
  <client-only>
    <nav class="breadcrumb">
      <span
        class="breadcrumb-item"
        @click="navigateTo('/')"
        :class="{ current: route.path === '/' }"
        >Página inicial
      </span>
      <span
        class="breadcrumb-item"
        :class="{ current: route.path === value.path }"
        v-for="(value, index) in breadcrumb.path"
        :key="index"
        @click="navigateTo(value.path)"
      >
        <span class="breadcrumb-separator"> > </span>
        <span v-show="value.name">{{ value.name }}</span>
      </span>
    </nav>
  </client-only>
</template>

<script lang="ts">
import useBreadcrumbStore from '~/stores/useBreadcrumbStore';

export default defineComponent({
  name: 'Breadcrumb',

  data: () => ({
    breadcrumb: useBreadcrumbStore(),
    route: useRoute(),
    router: useRouter(),
  }),

  mounted() {
    window.addEventListener('beforeunload', (event) => {
      // event.preventDefault();
      localStorage.setItem(
        'breadcrumb',
        JSON.stringify({
          course: this.breadcrumb.course,
          subject: this.breadcrumb.subject,
          sign: this.breadcrumb.sign,
        }),
      );
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

<style lang="scss" scoped>
.breadcrumb {
  margin: 0em;
  display: flex;
  gap: 0.5em;
}
.breadcrumb-item {
  cursor: pointer;
  user-select: none;
  &.clickable {
    cursor: pointer;
    &:hover {
      color: $primary-color-hovered;
      text-decoration: underline;
    }
  }
}
.current {
  color: $primary-color-hovered;
}
</style>
