<template>
  <div class="relative w-full" style="height: 260px;">
    <canvas ref="canvas"></canvas>
  </div>
</template>

<script>
import { defineComponent, onMounted, ref } from 'vue';
import { Chart, BarElement, CategoryScale, LinearScale, Tooltip, Legend, BarController } from 'chart.js';

Chart.register(BarElement, CategoryScale, LinearScale, Tooltip, Legend, BarController);

export default defineComponent({
  name: 'SalesFunnel',
  props: {
    stages: {
      type: Array,
      required: true,
    },
    darkMode: {
      type: Boolean,
      default: false,
    },
  },
  setup(props) {
    const canvas = ref(null);

    onMounted(() => {
      const labels = props.stages.map(s => s.label);
      const data   = props.stages.map(s => s.count);

      const colors = [
        'rgba(99, 102, 241, 0.85)',
        'rgba(34, 197, 94, 0.85)',
        'rgba(107, 114, 128, 0.75)',
      ];

      const textColor = props.darkMode ? '#9ca3af' : '#6b7280';
      const gridColor = props.darkMode ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';

      new Chart(canvas.value, {
        type: 'bar',
        data: {
          labels,
          datasets: [{
            label: 'Deals',
            data,
            backgroundColor: colors,
            borderRadius: 8,
            borderSkipped: false,
          }],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: {
              callbacks: {
                label: ctx => ` ${ctx.parsed.y} deals`,
              },
            },
          },
          scales: {
            x: {
              ticks: { color: textColor, font: { size: 12 } },
              grid: { display: false },
            },
            y: {
              beginAtZero: true,
              ticks: { color: textColor, font: { size: 11 }, stepSize: 1 },
              grid: { color: gridColor },
            },
          },
        },
      });
    });

    return { canvas };
  },
});
</script>
