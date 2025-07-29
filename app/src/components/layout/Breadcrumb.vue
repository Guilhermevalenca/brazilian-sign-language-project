<template>
  <client-only>
    <nav class="breadcrumb">
      <span
        class="breadcrumb-item"
        :class="{ current: route.path === '/' }"
        @click="navigateTo('/')"
        >Página inicial
      </span>
      <span
        v-for="(value, index) in breadcrumb.path"
        :key="index"
        class="breadcrumb-item"
        :class="{ current: route.path === value.path }"
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
    window.addEventListener('beforeunload', () => {
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
  margin: 0;
  display: flex;
  gap: 0.5rem;
}
.breadcrumb-item {
  min-width: 2rem;
  max-width: 15rem;
  white-space: nowrap;
  overflow: hidden;    
  text-overflow: ellipsis;
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
