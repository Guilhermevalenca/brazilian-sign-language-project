<template>
  <client-only>
    <LazyLayoutAppHeader />
  </client-only>
  <main>
    <slot />
  </main>
  <client-only>
    <LazyLayoutAppFooter />
  </client-only>
</template>