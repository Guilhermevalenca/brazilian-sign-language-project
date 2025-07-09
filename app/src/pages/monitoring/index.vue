<script setup lang="ts">
import { Bar, Doughnut } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  CategoryScale,
  LinearScale,
  BarElement,
  ArcElement,
} from 'chart.js';
import UserMonitoringService from '~/services/UserMonitoringService';
import type { AvgPartOfPageType } from '~/types/UserMonitoring';
import useBreadcrumbStore from '~/stores/useBreadcrumbStore';

ChartJS.register(Title, Tooltip, Legend, CategoryScale, LinearScale, BarElement, ArcElement);

const { data, status, refresh } = await useAsyncData(
  'fetch-user-monitoring',
  () => UserMonitoringService.fetch(),
  {
    default: () => ({
      avgPartOfPage: [],
    }),
  },
);

onMounted(async () => {
  UserMonitoringService.fetch();
});

const avgPartOfPage = computed((): AvgPartOfPageType[] => {
  if (data.value.avgPartOfPage) {
    const translated = data.value.avgPartOfPage.map(
      ({ part_of_page, count }: AvgPartOfPageType) => {
        let part = '';
        switch (part_of_page) {
          case 'subject':
            part = 'Disciplina';
            break;
          case 'course':
            part = 'Curso';
            break;
          case 'home':
            part = 'Pagina inicial';
            break;
          case 'search':
            part = 'Busca';
            break;
          case 'sign':
            part = 'Sinais';
            break;
          default:
            part = 'Outro';
            break;
        }

        return {
          part_of_page: part,
          count,
        };
      },
    );

    const response = translated.filter((item: AvgPartOfPageType) => item.part_of_page !== 'Outro');
    let totalOther = 0;
    translated.forEach((item: AvgPartOfPageType) => {
      if (item.part_of_page === 'Outro') {
        totalOther += item.count;
      }
    });
    if (totalOther > 0) {
      response.push({
        part_of_page: 'Outro',
        count: totalOther,
      });
    }
    return response;
  }
  return [];
});

const barOptions = {
  responsive: true,
  plugins: {
    legend: { display: false },
    title: { display: true, text: 'Quantidade de acessos por paginas' },
  },
};

onMounted(() => {
  useBreadcrumbStore().activeMonitoring();
});
</script>

<template>
  <client-only>
    <div class="tw-grid tw-gap-6 tw-lg:grid-cols-2">
      <Bar
        v-if="avgPartOfPage.length > 0"
        :data="{
          labels: avgPartOfPage.map((i) => i.part_of_page),
          datasets: [
            {
              label: 'Quantidade de acessos',
              data: avgPartOfPage.map((i) => i.count),
            },
          ],
        }"
        :options="barOptions"
        class="tw-rounded-2xl tw-shadow tw-p-4"
      />
    </div>
  </client-only>
</template>
