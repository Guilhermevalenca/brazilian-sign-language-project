<template>
  <client-only>
    <LazyAppHeader />
  </client-only>
  <main>
    <slot />
  </main>
  <client-only>
    <LazyAppFooter />
  </client-only>
</template>