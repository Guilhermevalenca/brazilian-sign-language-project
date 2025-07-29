<template>
  <client-only>
    <AppSelect
      v-model="selected"
      :items="courses"
      labelInput="name"
      placeholder="Pesquise pelo curso"
      id="course"
    />
  </client-only>
</template>

<script setup lang="ts">
import type { CourseType } from '~/types/Course';
import CourseService from '~/services/CourseService';

const props = defineProps({
  modelValue: {
    type: Array as PropType<CourseType[]>,
    required: true,
  },
});

const emit = defineEmits(['update:modelValue']);

const selected = computed({
  get(): CourseType[] {
    return props.modelValue;
  },
  set(value: CourseType[]) {
    emit('update:modelValue', value);
  },
});

const courses = ref<CourseType[]>([]);
const page = ref<number>(1);
const last_page = ref<number>(1);

const { refresh } = await useAsyncData(
    'fetch-courses-all-' + page.value,
    async () => {
      const data = await CourseService.fetch(page.value);
      courses.value.push(...data.courses);
      last_page.value = data.last_page;
      return null;
    }
);

onMounted(() => {
  const moreCourses = async () => {
    if (page.value < last_page.value) {
      page.value++;
      await refresh();
      setTimeout(moreCourses, 300);
    }
  };
  setTimeout(moreCourses, 300);
})
</script>