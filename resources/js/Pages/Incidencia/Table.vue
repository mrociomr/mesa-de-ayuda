<template>
  <Head title="Incidencias" />
  <AuthenticatedLayout>
   
    <div v-if="$page.props.flash.message" class="fixed z-50 top-4 right-4">
      <Notification :message="$page.props.flash.message" />
    </div>
    
      <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 my-5">
        <div class="flex items-center">
          <div class="flex-shrink-0">
             <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{incidenciasPendientes}}</span>
             <h3 class="text-base font-normal text-gray-500">Incidencias pendientes</h3>
          </div>
          <div class="ml-5 w-0 flex items-center justify-end flex-1 text-green-500 text-base font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
            </svg>

          </div>
       </div>
      </div>
   <!--   <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 my-5">
        <div class="flex items-center">
          <div class="flex-shrink-0">

             <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">79</span>
             <h3 class="text-base font-normal text-gray-500">Incidencias atendidas</h3>
          </div>
          <div class="ml-5 w-0 flex items-center justify-end flex-1 text-blue-500 text-base font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" />
            </svg>


          </div>
       </div>
      </div> -->
  

    <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
      <div class="grid grid-rows-1 grid-flow-col">
        <div class="flex justify-content-end">
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
          <Link :href="route('incidencia.create')" label="Crear">
            <Button icon="pi pi-plus" label="Crear" raised />
          </Link>
        </div>
      </div>

      <div class="py-10">
        <DataTableComponent
        :data="Incidencia"
        :columns="tableColumns"
        :perPage="6"
        @solution="solutionRow"
        :showButtonSolution="showButton"

      >
        <!--
        @delete="deleteRow"
        :showButtonDelete="showButton"
        @edit="editRow"
        :showButtonEdit="showButton"
      -->

      </DataTableComponent>
      </div>


    </div>

  </AuthenticatedLayout>
</template>


<script setup>
import DataTableComponent from "@/Components/TablePrimeVue.vue";
import { ref, computed } from "vue";
import { Head, useForm, Link } from "@inertiajs/inertia-vue3";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Notification from "@/Components/Notification.vue";

const form = useForm({});

const props = defineProps(["incidencia", "tableColumns", "incidenciasPendientes"]);
//console.log(props.incidencia);
const id = ref();

const nombreFilter = ref("");
const Incidencia = computed(() => {
  if (!nombreFilter.value) {
    return props.incidencia;
  }
  const filter = nombreFilter.value.toLowerCase();
  return props.incidencia.filter((item) =>
    item.dni.toLowerCase().includes(filter)
    || item.celular.toLowerCase().includes(filter)

  );
});

const applyFilter = () => {};


const showButton = ref(true);

const toggleButton = () => {
showButton.value = !showButton.value;
};

const editRow = (rowData) => {
    //console.log("incidencia.edit", rowData);
  form.get(route("incidencia.edit",rowData))
};

const deleteRow = (rowId) => {
  //console.log("Delete row with ID:", rowId);
  form.delete(route("incidencia.destroy", rowId));
};

const solutionRow = (rowId) => {
  //console.log("Aceptar row with ID:", rowId);
  form.get(route("solucion.create", rowId));
};
</script>




