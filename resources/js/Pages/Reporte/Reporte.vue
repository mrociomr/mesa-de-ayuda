<template>
  <Head title="Reportes" />
  <AuthenticatedLayout>
    <div
      class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 2xl:col-span-2 text-sm"
    >
      <div class="grid grid-rows-1 grid-flow-col">
        <div class="flex justify-start">
          <span class="p-input-icon-left">
            <i class="pi pi-search" />
            <InputText
              v-model="nombreFilter"
              @input="applyFilter"
              placeholder="Buscar..."
            />
          </span>
          
        </div>
        <div class="flex justify-end">
          <Button
            @click="generatePDF"
            label="Generar Reporte"
            icon="pi pi-plus"
            raised
          />
        </div>
        <div>
          <div>
            <label for="mes">Selecciona un mes:</label>
            <select v-model="selectedMonth" id="mes" @change="enviarMes">
              <option value="9">Enero</option>
              <option value="10">Febrero</option>
              <!-- Agrega más opciones para otros meses -->
            </select>
          </div>
        </div>
      </div>
      <div class="py-10">
        <DataTableComponent
          :data="reporte"
          :columns="tableColumns"
          :perPage="6"
        />
      </div>
    </div>
    <br />
    <div
      class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 2xl:col-span-2 text-sm"
    >
      <div class="py-10">
        <div class="chart-container overflow-x-scroll overflow-y-scroll">
          <div class="chart-wrapper">
            <Chart
              type="line"
              :data="chartData1"
              :options="chartOptions1"
              class="chart-container1 w-full min-w-full mx-auto my-auto"
            />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>


  <script setup>
import DataTableComponent from "@/Components/TablePrimeVue.vue";
import { ref, computed, onMounted } from "vue";
import { Head, useForm, Link } from "@inertiajs/vue3";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Inertia } from "@inertiajs/inertia";

import { imgData1 } from "./Image1.js";
import { imgData2 } from "./Image2.js";
import { font1 } from "./font1.js";
import { font2 } from "./font2.js";
import { phone } from "./phone.js";
import { email } from "./email.js";

const form = useForm({});

const props = defineProps(["reporte", "tableColumns", "graficoData", "mess"]);

console.log(props.reporte)
let datass;
if (props.reporte && Array.isArray(props.reporte) && props.reporte.length > 0) {
  const columnNames = Object.keys(props.reporte[0]);

  // Crea un array de arrays que represente los datos en el formato deseado
datass = [columnNames];

  // Recorre los datos y conviértelos en arrays
  props.reporte.forEach(item => {
    const rowData = columnNames.map(columnName => item[columnName]);
    datass.push(rowData);
  });

  // Quita la primera fila que contiene los nombres de las columnas
  datass.shift();

  console.log(datass);
} else {
  console.error("El objeto props.reporte es undefined, null o vacío.");
}

console.log(datass);

// const columnNames = Object.keys(props?.reporte[0]);

// // Crea un array de arrays que represente los datos en el formato deseado
// const datass = [columnNames];

// // Recorre los datos y conviértelos en arrays
// props.reporte.forEach(item => {
//   const rowData = columnNames.map(columnName => item[columnName]);
//   datass.push(rowData);
// });
// datass.shift();


const selectedMonth = ref(1); // Establece un valor predeterminado (por ejemplo, enero) o el que desees.

const enviarMes = () => {
  // Obtén el valor del mes seleccionado
  const mesSeleccionado = selectedMonth.value;
  // Realiza una solicitud GET a la ruta index con el parámetro mes
  Inertia.visit(route("reporte.index", { mes: mesSeleccionado }));
};



const nombreFilter = ref("");
const Reporte = computed(() => {
  if (!nombreFilter.value) {
    return props.reporte;
  }
  const filter = nombreFilter.value.toLowerCase();
  return props.reporte.filter(
    (item) =>
      item.descripcion.toLowerCase().includes(filter) ||
      item.abreviatura.toLowerCase().includes(filter)
  );
});

const applyFilter = () => {};

//Grafico
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
  fill: item.fill,
  //backgroundColor: getRandomColor(),
  borderColor: getRandomColor(),
  //yAxisID: item.yAxisID,
  tension: item.tension,
  data: item.data,
}));


onMounted(() => {
  chartData1.value = setChartData1();
  chartOptions1.value = setChartOptions1();
});

const chartData1 = ref();
const chartOptions1 = ref();

const setChartData1 = () => {
  const documentStyle = getComputedStyle(document.documentElement);

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
    aspectRatio: 0.6,
    plugins: {
      legend: {
        labels: {
          color: textColor,
        },
      },
    },
    scales: {
      x: {
        ticks: {
          color: textColorSecondary,
        },
        grid: {
          color: surfaceBorder,
        },
      },
      y: {
        ticks: {
          color: textColorSecondary,
        },
        grid: {
          color: surfaceBorder,
        },
      },
    },
  };
};

//PDF
import jsPDF from "jspdf";
import html2canvas from "html2canvas";
import "jspdf-autotable";

const generatePDF = () => {
  const doc = new jsPDF({
    unit: "mm",
    format: "a4",
    orientation: "portrait",
    marginLeft: 10,
    marginRight: 10,
    marginTop: 10,
    marginBottom: 10,
    dpi: 300, // Ajusta la resolución
  });

 

  doc.setFont("Courier", "bold");
  doc.setFontSize(18);
  doc.text("REPORTE MENSUAL DE INCIDENCIAS", 50, 40);

  doc.setFontSize(11);
  doc.setFont("Helvetica", "bold");
  doc.text('Generado por: ', 20, 50);
  doc.text('Cargo:', 20, 55);
  doc.text('Mes:', 20, 60);
  doc.text('Año:', 20, 65);
  doc.text('Fecha:', 20,70);

  doc.addImage(imgData1, "JPEG", 15, 5, 17, 20);
  doc.addImage(imgData2, "PNG", 175, 6, 25, 20);

  const chartContainer = document.querySelector(".chart-container");
  const chartWidth = chartContainer.offsetWidth;
  const chartHeight = chartContainer.offsetHeight;

  

  //IMAGEN (CHART)
  // Aumenta la resolución de la imagen capturada
  const scale = 2; // Puedes ajustar este valor según tus necesidades

  html2canvas(chartContainer, {
    scale: scale,
  }).then((canvas) => {
    const data = datass
    doc.autoTable({
      head: [
        [
          "N°",
          "Tipo de Problema",
          "Tipo de Solución",
          "Descripción",
          "Equipo",
          "Oficina",
          "Estado",
          "Fecha de atención",
        ],
      ],
      body: data,
      startY: 80,
      theme: 'plain',
    });

    const chartImage = canvas.toDataURL("image/jpeg", 1.0); // Utiliza un formato de alta calidad (JPEG) y calidad máxima

    const pdfWidth = doc.internal.pageSize.getWidth() - 20;
    const imageWidth = pdfWidth;
    const imageHeight = (chartHeight / chartWidth) * imageWidth;

    doc.addPage();
    doc.setFont('Courier');
    doc.setFontSize(17);
    doc.text("Gráfico Resumen por tipo de problema:", 10, 30);
    doc.addImage(chartImage, "JPEG", 10, 40, imageWidth, imageHeight);


    //PAGE NUMBERING
  const pageCount = doc.internal.getNumberOfPages();

for (var i=1; i <= pageCount; i++){
  doc.setPage(i);


  doc.addFileToVFS("Pacifico-Regular.ttf", font1);
  doc.setFontSize(20);
  doc.setTextColor(41,49,51);
  doc.addFont("Pacifico-Regular.ttf", "Pacifico-Regular", "Regular");
  doc.setFont("Pacifico-Regular", "Regular");
  doc.text("Municipalidad Provincial de Puno", 55, 13);

  console.log(doc.getFontList());

  doc.addFileToVFS("LexendDeca-Thin.ttf", font2);
  doc.setFontSize(15);
  doc.addFont("LexendDeca-Thin.ttf", "LexendDeca-Thin", "Regular");
  doc.setFont("LexendDeca-Thin", "Regular");
  doc.text("Oficina de Tecnología Informática", 65, 23);

  doc.setDrawColor(17, 42, 74);
  doc.line(0, 28, 215, 28, "S");
  
  doc.setLineWidth(0.5);
  doc.line(0, 29, 215, 29, "S");
  
  doc.setFont("Helvetica", "Bold");
  doc.setFillColor(72,61,139);
  doc.rect(0, 285, 220, 10, 'F');
  doc.setTextColor(255,255,255);
  doc.setFontSize(8);
  doc.addImage(phone, "PNG", 18, 287, 5, 5);
  doc.text("TELÉFONO: (051)368591 - ANEXO 4010", 25, 291);

  doc.addImage(email, "PNG", 123, 287, 5, 5);
  doc.text("CORREO: OTI@MUNIPUNO.GOB.PE", 130, 291);

}
    doc.save("reporte_mesa_ayuda.pdf");
  });
};
</script>



  <style scoped>
.chart-container {
  max-width: 100%;
}

/* En tu archivo CSS o en un bloque <style> */
.chart-container1 {
  width: 300px; /* Establece el ancho que desees */
  height: 400px; /* Establece la altura que desees */
}

.chart-wrapper {
  min-width: 600px; /* Tamaño mínimo del gráfico */
  /*  min-height: 400px; /* Tamaño mínimo del gráfico */
  overflow: auto;
}
</style>
