<template>
  <Head title="Incidencias Atendidas" />
    <AuthenticatedLayout>
      <div v-if="$page.props.flash.message" class="fixed z-50 top-4 right-4">
        <Notification :message="$page.props.flash.message" />
      </div> 
      <div class="w-full grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-2 gap-4">
        <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 my-5">
          <div class="flex items-center">
            <div class="flex-shrink-0">

             <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ incidenciasAtendidas}}</span>
             <h3 class="text-base font-normal text-gray-500">Incidencias atendidas</h3>
            </div>
            <div class="ml-5 w-0 flex items-center justify-end flex-1 text-blue-500 text-base font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" />
            </svg>
            </div>
       </div>
      </div> 
  
      <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 my-5">
        <div class="flex items-center">
          <div class="flex-shrink-0">

           <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ incidenciasRechazadas}}</span>
           <h3 class="text-base font-normal text-gray-500">Incidencias rechazadas</h3>
          </div>
          <div class="ml-5 w-0 flex items-center justify-end flex-1 text-red-500 text-base font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            
          </div>
     </div>
    </div>
     </div>

      <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8  2xl:col-span-2 text-sm">
        <div class="grid grid-rows-1 grid-flow-col">
          <div class="flex justify-start">
            <span class="p-input-icon-left">
              <i class="pi pi-search" />
              <InputText
                v-model="nombreFilter"
                @input="applyFilter"
                placeholder="Buscar... "
              />
            </span>
          </div>
         
        </div>
        <div class="py-10">
          <DataTableComponent
        :data="Solucion"
        :columns="tableColumns"
        :perPage="6"
        @edit="editRow"
        :showButtonEdit="showButton"
      >
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

  const props = defineProps(["solucion", "tableColumns", "incidenciasAtendidas", "incidenciasRechazadas"]);

  const nombreFilter = ref("");
  const Solucion = computed(() => {
    if (!nombreFilter.value) {
      return props.solucion;
    }
    const filter = nombreFilter.value.toLowerCase();
    return props.solucion.filter((item) =>
      item.descripcion.toLowerCase().includes(filter)
      || item.equipos.toLowerCase().includes(filter)
      || item.tipo_solucion.nombre.toLowerCase().includes(filter)
    );
  });

  const applyFilter = () => {};

  const showButton = ref(true);

  const toggleButton = () => {
    showButton.value = !showButton.value;
  };

  const editRow = (rowData) => {
    form.get(route("solucion.edit",rowData))
  };

  const deleteRow = (rowId) => {
    form.delete(route("solucion.destroy", rowId));
  };

</script>
