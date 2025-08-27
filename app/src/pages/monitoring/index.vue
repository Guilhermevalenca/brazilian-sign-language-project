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

const avgPartOfPage = computed((): AvgPartOfPageType[] => {
  if (data.value.avgPartOfPage) {
    const translated = data.value.avgPartOfPage.map(
      ({ part_of_page, average_daily }: AvgPartOfPageType) => {
        let part = '';
        let color = '';

        switch (part_of_page) {
          case 'subject':
            part = 'Disciplina';
            color = '#3B82F6';
            break;
          case 'course':
            part = 'Curso';
            color = '#10B981';
            break;
          case 'home':
            part = 'Página inicial';
            color = '#F59E0B';
            break;
          case 'search':
            part = 'Busca';
            color = '#8B5CF6';
            break;
          case 'sign':
            part = 'Sinais';
            color = '#EF4444';
            break;
          default:
            part = 'Outro';
            color = '#6B7280';
        }

        return {
          part_of_page: part,
          average_daily: Math.round(average_daily),
          color,
        };
      },
    );

    const response = translated.filter((item: AvgPartOfPageType) => item.part_of_page !== 'Outro');
    let totalOther = 0;
    translated.forEach((item: AvgPartOfPageType) => {
      if (item.part_of_page === 'Outro') {
        totalOther += item.average_daily;
      }
    });
    if (totalOther > 0) {
      response.push({
        part_of_page: 'Outro',
        average_daily: totalOther,
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
    title: { display: true, text: 'Quantidade de acessos desde 08 de AGOSTO de 2025' },
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
              label: barOptions.plugins.title.text,
              data: avgPartOfPage.map((i) => i.average_daily),
              backgroundColor: avgPartOfPage.map((i) => i.color),
            },
          ],
        }"
        :options="barOptions"
        class="tw-rounded-2xl tw-shadow tw-p-4"
      />
    </div>
  </client-only>
</template>
