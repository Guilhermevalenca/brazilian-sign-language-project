<template>
  <div :class="['card-default', variants[variant]]" v-bind="$attrs">
    <slot />
  </div>
</template>

<script lang="ts">
export default {
  name: 'AppCard',
  props: {
    variant: {
      type: String,
      default: 'default',
      validator: (value: string) => ['default', 'list', 'screen'].includes(value),
    },
  },
  computed: {
    variants() {
      return {
        default: 'card-default',
        list: 'card-list',
        screen: 'screen-card',
      };
    },
  },
};
</script>

<style lang="scss" scoped>
.card-default {
  display: flex;
  flex-flow: column wrap;
  text-wrap: auto;
  overflow-wrap: break-word;
  word-break: break-word;
  gap: 1rem;
  justify-self: center;
  align-items: center;
  justify-content: center;
  background-color: $tertiary-color;
  padding: 2rem;
  min-width: 40vw;
  max-width: 40vw;
  height: fit-content;
  box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.2);
  border-radius: 2rem;
}
.screen-card {
  @extend .card-default;
  min-width: 50vw;
  max-width: 50vw;
}
.card-list {
  @extend .card-default;
  padding: 1em;
  flex-direction: row;
  justify-content: flex-start;
  align-items: center;
  cursor: pointer;
}
</style>
