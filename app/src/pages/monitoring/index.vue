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

const order = ['Página inicial', 'Busca', 'Cursos', 'Disciplinas', 'Sinais', 'Outros'];
const avgPartOfPage = computed((): AvgPartOfPageType[] => {
  if (data.value.avgPartOfPage) {
    const translated = data.value.avgPartOfPage;

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

    return response.sort((a: AvgPartOfPageType, b: AvgPartOfPageType) => {
      const indexA = order.indexOf(a.part_of_page);
      const indexB = order.indexOf(b.part_of_page);

      // Se não encontrar, coloca no final
      const finalIndexA = indexA === -1 ? order.length : indexA;
      const finalIndexB = indexB === -1 ? order.length : indexB;

      return finalIndexA - finalIndexB;
    });
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
