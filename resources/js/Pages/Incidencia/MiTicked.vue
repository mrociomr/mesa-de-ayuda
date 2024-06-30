
<template>
<div class="background-image"
  style="
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
  "
>
<div ref="cardContent" class="flex justify-center items-center border"
style="text-align:center;overflow: hidden; background: white">
      <div class="max-w-lg rounded overflow-hidden shadow-lg" style="background: white">
      <img class="w-full"
      :src="ImgFondoCard"
      alt="">
        <div class="px-6 py-4" style="background: white">
          <div class="font-bold text-xl mb-2" style="background: white">Municipalidad Provincial de Puno
        </div>
        <p class="font-bold text-lg mb-2 text-slate-500	" style="background: white">PUNO-PUNO-PERU
        </p>
        <!-- <pre>{{ dataTicked }}</pre> -->
          <p class="m-0" style="background: white">
        <table style="width: 100%">
          <thead>
            <tr >
              <th style="width: 10%; text-align:start"> </th>
              <th style="width: 30%; text-align:start">Mi TICKED N° </th>
              <th style="width: 10%; text-align:start"> : </th>
              <td style="width: 50%; text-align:start" v-if="dataTicked[0]?.nTicket">{{ dataTicked[0]?.nTicket }}</td>
            </tr>
            <tr >
              <th style="width: 10%; text-align:start"> </th>
              <th style="width: 30%; text-align:start">N° DNI </th>
              <th style="width: 10%; text-align:start"> : </th>
              <td style="width: 50%; text-align:start" v-if="dataTicked[0]?.dni">{{ dataTicked[0]?.dni }}</td>
            </tr>
            <tr>
              <th style="width: 10%; text-align:start"> </th>
              <th style="width: 30%; text-align:start">Fecha </th>
              <th style="width: 10%; text-align:start"> : </th>
              <td style="width: 50%; text-align:start" v-if="dataTicked[0]?.fecha">{{ formatFecha(dataTicked[0]?.fecha) }}</td>
            </tr>
            <tr>
              <th style="width: 10%; text-align:start"> </th>
              <th style="width: 30%; text-align:start">Oficina </th>
              <th style="width: 10%; text-align:start"> : </th>
              <td style="width: 50%; text-align:start" v-if="dataTicked[0]?.nTipoProblema">{{ dataTicked[0]?.nTipoProblema }}</td>
            </tr>
            <tr>
              <th style="width: 10%; text-align:start"> </th>
              <th style="width: 30%; text-align:start">Tipo de Problema </th>
              <th style="width: 10%; text-align:start"> : </th>
              <td style="width: 50%; text-align:start" v-if="dataTicked[0]?.nOficina">{{ dataTicked[0].nOficina }}</td>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </p>
        </div>

      </div>
</div>


  <!-- <Card ref="cardContent" style="width: 35rem; text-align:center;overflow: hidden; background: red">
    <template #header>
      <img
        alt="user header"
        :src="ImgFondoCard"
        @load="imagenCargada"

      />
    </template>
    <template #title>Municipalidad Provincial de Puno</template>
    <template #subtitle>PUNO-PUNO-PERU</template>
    <template  #content>
      <p class="m-0" style="background: white">
        <table style="width: 100%">
          <thead>
            <tr>
              <th style="width: 10%; text-align:start"> </th>
              <th style="width: 30%; text-align:start">Mi TICKED N° </th>
              <th style="width: 10%; text-align:start"> : </th>
              <td style="width: 50%; text-align:start">d</td>
            </tr>
            <tr>
              <th style="width: 10%; text-align:start"> </th>
              <th style="width: 30%; text-align:start">Hora de Incidencia </th>
              <th style="width: 10%; text-align:start"> : </th>
              <td style="width: 50%; text-align:start">Hora</td>
            </tr>
            <tr>
              <th style="width: 10%; text-align:start"> </th>
              <th style="width: 30%; text-align:start">Tipo de Problema </th>
              <th style="width: 10%; text-align:start"> : </th>
              <td style="width: 50%; text-align:start">Hora</td>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </p>
    </template>
  </Card> -->
<br/>
  <Card style="width: 35rem; text-align:center;overflow: hidden">
    <template #footer>
      <div class="flex gap-3 mt-1">
        <Button label="Salir" severity="secondary" @click="regresarInicio" outlined class="w-full" />
        <Button label="Guardar" @click="guardarImagen" class="w-full" />
      </div>
    </template>
  </Card>
</div>


</template>

<script setup>
import ImgFondoCard from "./fondoM.png";
import { ref, onMounted } from "vue";
import html2canvas from "html2canvas";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps(["dataTicked"]);

const cardContent = ref(null);

const regresarInicio = () => {
    window.location.href = "/loginAyuda";
}
const guardarImagen = () => {
  html2canvas(cardContent.value, {
    backgroundColor: "#ffffff",
    useCORS: true,
  }).then((canvas) => {
    const imgData = canvas.toDataURL("image/png");
    const downloadLink = document.createElement("a");
    downloadLink.href = imgData;
    downloadLink.download =  `ticked-${props.dataTicked[0].nTicket}.png` ;
    downloadLink.click();
  });
};

const imagenCargada = () => {
  console.log("La imagen de fondo se ha cargado correctamente");
  // Puedes realizar otras acciones aquí si es necesario
  // Por ejemplo, podrías intentar capturar la imagen aquí
  // Pero asegúrate de que la imagen esté completamente cargada antes de llamar html2canvas
  // html2canvas(cardContent.value.$el).then(canvas => {
  //   const imgData = canvas.toDataURL('image/png');
  //   const downloadLink = document.createElement('a');
  //   downloadLink.href = imgData;
  //   downloadLink.download = 'mi_imagen.png';
  //   downloadLink.click();
  // });
};

const meses = [
  "enero",
  "febrero",
  "marzo",
  "abril",
  "mayo",
  "junio",
  "julio",
  "agosto",
  "septiembre",
  "octubre",
  "noviembre",
  "diciembre",
];

const formatFecha = (fecha) => {
  const date = new Date(fecha);
  const dia = date.getDate();
  const mes = meses[date.getMonth()];
  const anio = date.getFullYear();
  const horas = date.getHours().toString().padStart(2, "0");
  const minutos = date.getMinutes().toString().padStart(2, "0");
  const segundos = date.getSeconds().toString().padStart(2, "0");

  return `${dia} de ${mes} del ${anio} - ${horas}:${minutos}:${segundos}`;
};
</script>

<style scoped>
.background-image {
  background-image: url("./fondoM.png"); /* Reemplaza 'tu-imagen.jpg' con el nombre de tu imagen */
  background-size: cover;
  background-position: center;
  height: 100vh; /* Ajusta la altura según tus necesidades */
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
</style>
