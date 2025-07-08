<template>
  <button :class="['button-default', variants[variant]]" v-bind="$attrs">
    <slot />
  </button>
</template>

<script lang="ts">
export default {
  name: 'ButttonApp',
  props: {
    variant: {
      type: String,
      default: 'default',
      validator: (value: string) => ['default', 'allow', 'deny', 'navigation'].includes(value),
    },
  },
  computed: {
    variants() {
      return {
        default: 'button-default',
        navigation: 'button-navigation',
        allow: 'button-allow',
        deny: 'button-deny',
      };
    },
  },
};
</script>

<style lang="scss" scoped>
.button-default {
  display: flex;
  flex-flow: row;
  align-content: center;
  align-items: center;
  justify-content: center;
  padding: 1rem;
  gap: 0.5rem;
  font-weight: bold;
  background-color: $secondary-color;
  border: none;
  border-radius: 1rem;
  box-shadow: 0px -2px 0px 0px rgb(0, 0, 0, 0.3) inset;
  width: auto;
  min-width: 8rem;
  height: 2.5rem;
  user-select: none;
}
.button-default:hover {
  background-color: #1e5ac0;
}
.button-default:active {
  background-color: #1e5ac0;
  box-shadow: 0px -1px 0px 0px rgb(0, 0, 0, 0.3) inset;
  transform: translateY(4px);
}
.button-navigation {
  justify-content: flex-start;
  background-color: $primary-color;
}
.button-navigation:hover {
  background-color: $primary-color-hovered;
}
.button-allow {
  background-color: #00ff00;
}
.button-allow:hover {
  background-color: #00e600;
}
.button-allow:active {
  background-color: #00e600;
}
.button-deny {
  background-color: rgb(255, 0, 0, 0.7);
}
.button-deny:hover {
  background-color: rgb(255, 0, 0, 0.8);
}
.button-deny:active {
  background-color: rgb(255, 0, 0, 0.8);
}
</style>
