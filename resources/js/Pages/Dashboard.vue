<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, onMounted, computed } from "vue";
import DataTableComponent from "@/Components/TablePrimeVue.vue";
import { Head, useForm, Link } from "@inertiajs/inertia-vue3";

const showButton = ref(true);

const toggleButton = () => {
  showButton.value = !showButton.value;
};

const form = useForm({});

const props = defineProps([
  "GrafPendSolu",
  "graficoData",
  "datosDias",
  "datosSemana",
  "datosMes",
  "resultadocatAR",
  "incidencias",
  "tableColumns",
]);

console.log(props.resultadocatAR);

const cantidad_dia = props?.datosDias[0]?.cantidad_incidencias || 0;
const cantidad_semana = props?.datosSemana[0]?.cantidad_incidencias || 0;
const cantidad_mes = props?.datosMes[0]?.cantidad_incidencias || 0;

const getRandomColor = () => {
  const letters = "0123456789ABCDEF";
  let color = "#";
  for (let i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
};

const backgroundColor1 = getRandomColor();
const borderColor1 = getRandomColor();

const nuevosDatasets = props.graficoData.datasets.map((item) => ({
  label: item.label,
  backgroundColor: getRandomColor(),
  borderColor: getRandomColor(),
  data: item.data,
}));

//console.log(props.GrafPendSolu);

onMounted(() => {
  chartData.value = setChartData();

  chartData1.value = setChartData1();
  chartData2.value = setChartData2();
  chartOptions1.value = setChartOptions1();
});

const chartData1 = ref();
const chartData2 = ref();
const chartOptions1 = ref();

const setChartData1 = () => {
  return {
    labels: props.graficoData.labels,
    datasets: nuevosDatasets,
  };
};
const setChartOptions1 = () => {
  const documentStyle = getComputedStyle(document.documentElement);
  const textColor = documentStyle.getPropertyValue("--text-color");
  const textColorSecondary = documentStyle.getPropertyValue(
    "--text-color-secondary"
  );
  const surfaceBorder = documentStyle.getPropertyValue("--surface-border");

  return {
    maintainAspectRatio: false,
    aspectRatio: 0.8,
    plugins: {
      legend: {
        labels: {
          fontColor: textColor,
        },
      },
    },
    scales: {
      x: {
        ticks: {
          color: textColorSecondary,
          font: {
            weight: 500,
          },
        },
        grid: {
          display: false,
          drawBorder: false,
        },
      },
      y: {
        ticks: {
          color: textColorSecondary,
        },
        grid: {
          color: surfaceBorder,
          drawBorder: false,
        },
      },
    },
  };
};

const chartData = ref();
const chartOptions = ref({
  plugins: {
    legend: {
      labels: {
        usePointStyle: true,
      },
    },
  },
});

//Mes

const meses = {
  1: "Enero",
  2: "Febrero",
  3: "Marzo",
  4: "Abril",
  5: "Mayo",
  6: "Junio",
  7: "Julio",
  8: "Agosto",
  9: "Septiembre",
  10: "Octubre",
  11: "Noviembre",
  12: "Diciembre",
};

const mesIncidenciaSolu = ref(props.GrafPendSolu?.[0]?.Mes || 0);

const nombreMes = computed(() => meses[mesIncidenciaSolu.value]);

//const mesInsicenciaSolu = props.GrafPendSolu[0].Mes;

const setChartData = () => {
  const documentStyle = getComputedStyle(document.body);
  return {
    labels: ["Incidencias Pendientes", "Incidencias Atendidas"],
    datasets: [
      {
        data: [
          props.GrafPendSolu[0]?.incidencias_pendientes || 0,
          props.GrafPendSolu[0]?.soluciones_realizadas || 0,
        ],
        backgroundColor: [
          documentStyle.getPropertyValue("--red-500"),
          documentStyle.getPropertyValue("--yellow-500"),
          documentStyle.getPropertyValue("--green-500"),
        ],
        hoverBackgroundColor: [
          documentStyle.getPropertyValue("--red-500"),
          documentStyle.getPropertyValue("--yellow-400"),
          documentStyle.getPropertyValue("--green-400"),
        ],
      },
    ],
  };
};

// Incidencia Rechazadas y Atendida por mes
const setChartData2 = () => {
  const documentStyle = getComputedStyle(document.body);
  return {
    labels: ["Incidencias Atendidas", "Incidencias Rechazadas"],
    datasets: [
      {
        data: [
          props.resultadocatAR[0]?.Cantidad_Aceptada || 0,
          props.resultadocatAR[0]?.Cantidad_Rechazada || 0,
        ],
        backgroundColor: [
          documentStyle.getPropertyValue("--blue-500"),
          documentStyle.getPropertyValue("--red-500"),
        ],
        hoverBackgroundColor: [
          documentStyle.getPropertyValue("--blue-400"),
          documentStyle.getPropertyValue("--red-400"),
        ],
      },
    ],
  };
};


const diasSemana = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
const fechaActual = new Date();
const diaActual = diasSemana[fechaActual.getDay()];
const nombreDiaActual = ref(diaActual);
</script>


<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div
      class="w-full grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-3 gap-4 py-4"
    >
      <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <span
              class="text-2xl sm:text-3xl leading-none font-bold text-gray-900"
              >{{ cantidad_dia }}</span
            >
            <h3 class="text-base font-normal text-gray-500">
              Incidencias del día {{ nombreDiaActual }}
            </h3>
          </div>
          <div
            class="ml-5 w-0 flex items-center justify-end flex-1 text-base font-bold"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              id="Outline"
              viewBox="0 0 24 24"
              width="30"
              height="30"
            >
              <path
                d="M19,1H5A5.006,5.006,0,0,0,0,6v8a5.006,5.006,0,0,0,5,5h6v2H7a1,1,0,0,0,0,2H17a1,1,0,0,0,0-2H13V19h6a5.006,5.006,0,0,0,5-5V6A5.006,5.006,0,0,0,19,1ZM5,3H19a3,3,0,0,1,3,3v7H2V6A3,3,0,0,1,5,3ZM19,17H5a3,3,0,0,1-2.816-2H21.816A3,3,0,0,1,19,17Z"
              />
            </svg>
          </div>
        </div>
      </div>
      <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <span
              class="text-2xl sm:text-3xl leading-none font-bold text-gray-900"
              >{{ cantidad_semana }}</span
            >
            <h3 class="text-base font-normal text-gray-500">
              Incidencias de la semana
            </h3>
          </div>
          <div
            class="ml-5 w-0 flex items-center justify-end flex-1 text-green-500 text-base font-bold"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              id="Layer_1"
              data-name="Layer 1"
              viewBox="0 0 24 24"
              width="30"
              height="30"
            >
              <path
                d="M17,24H7c-2.757,0-5-2.243-5-5V5C2,2.243,4.243,0,7,0h10c2.757,0,5,2.243,5,5v14c0,2.757-2.243,5-5,5ZM7,2c-1.654,0-3,1.346-3,3v14c0,1.654,1.346,3,3,3h10c1.654,0,3-1.346,3-3V5c0-1.654-1.346-3-3-3H7Zm11,4c0-.552-.448-1-1-1h-4c-.552,0-1,.448-1,1s.448,1,1,1h4c.552,0,1-.448,1-1Zm0,6c0-.552-.448-1-1-1h-4c-.552,0-1,.448-1,1s.448,1,1,1h4c.552,0,1-.448,1-1Zm0,6c0-.552-.448-1-1-1h-4c-.552,0-1,.448-1,1s.448,1,1,1h4c.552,0,1-.448,1-1ZM10,7v-2c0-.552-.448-1-1-1h-2c-.552,0-1,.448-1,1v2c0,.552,.448,1,1,1h2c.552,0,1-.448,1-1Zm0,6v-2c0-.552-.448-1-1-1h-2c-.552,0-1,.448-1,1v2c0,.552,.448,1,1,1h2c.552,0,1-.448,1-1Zm0,6v-2c0-.552-.448-1-1-1h-2c-.552,0-1,.448-1,1v2c0,.552,.448,1,1,1h2c.552,0,1-.448,1-1Z"
              />
            </svg>
          </div>
        </div>
      </div>
      <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <span
              class="text-2xl sm:text-3xl leading-none font-bold text-gray-900"
              >{{ cantidad_mes }}</span
            >
            <h3 class="text-base font-normal text-gray-500">
              Incidencias del mes {{ nombreMes }}
            </h3>
          </div>
          <div
            class="ml-5 w-0 flex items-center justify-end flex-1 text-green-500 text-base font-bold"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-7 w-7 text-blue-400"
              id="Outline"
              viewBox="0 0 24 24"
              width="30"
              height="30"
            >
              <path
                d="M19,2H18V1a1,1,0,0,0-2,0V2H8V1A1,1,0,0,0,6,1V2H5A5.006,5.006,0,0,0,0,7V19a5.006,5.006,0,0,0,5,5H19a5.006,5.006,0,0,0,5-5V7A5.006,5.006,0,0,0,19,2ZM2,7A3,3,0,0,1,5,4H19a3,3,0,0,1,3,3V8H2ZM19,22H5a3,3,0,0,1-3-3V10H22v9A3,3,0,0,1,19,22Z"
              />
              <circle cx="12" cy="15" r="1.5" />
              <circle cx="7" cy="15" r="1.5" />
              <circle cx="17" cy="15" r="1.5" />
            </svg>
          </div>
        </div>
      </div>
    </div>

    <div class="w-full grid grid-cols-1 xl:grid-cols-3 4xl:grid-cols-2 gap-4">
      <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-4 2xl:col-span-2">
        <div id="main-chart">
          <div class="text-center">
            <p class="text-2xl">El mes es: {{ nombreMes }}</p>
          </div>

          <div class="card flex justify-content-center">
            <Chart
              type="pie"
              :data="chartData"
              :options="chartOptions"
              class="w-full md:w-20rem"
            />
          </div>
          <div class="card flex justify-content-center">
            <Chart
              type="pie"
              :data="chartData2"
              :options="chartOptions"
              class="w-full md:w-20rem"
            />
          </div>
        </div>
      </div>

      <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-4 1xl:col-span-2">
  <div class="mb-4 flex items-center justify-between">
    <div>
      <h3 class="text-lg font-bold text-gray-900 mb-2">
        Últimas incidencias
      </h3>
      <span class="text-sm font-normal text-gray-500">
        Esta es la lista de incidencias más recientes
      </span>
    </div>
    <div class="flex-shrink-0">
      <a
        href="/incidencia"
        class="text-sm font-medium text-cyan-600 hover:bg-gray-100 rounded-lg p-2"
      >Ver todo</a>
    </div>
  </div>
  <div class="flex flex-col mt-8">
    <div class="overflow-x-auto rounded-lg">
      <div class="align-middle inline-block min-w-full">
        <div class="shadow overflow-hidden sm:rounded-lg">
          <DataTableComponent
            :data="incidencias"
            :columns="tableColumns"
            :perPage="6"
            @solution="solutionRow"
            :showButtonSolution="showButton"
          >
          </DataTableComponent>
        </div>
      </div>
    </div>
  </div>
</div>

    </div>
    <!-- <div class="bg-white shadow rounded-lg p-10 sm:p-8 xl:p-12">
      <div class="card">
        <Chart
          type="bar"
          :data="chartData1"
          :options="chartOptions1"
          class="h-30rem"
        />
      </div>
    </div> -->
  </AuthenticatedLayout>
</template>