<template>
  <Head title="Tipos de solución" />
  <AuthenticatedLayout>
    <div v-if="$page.props.flash.message" class="fixed z-50 top-4 right-4">
      <Notification :message="$page.props.flash.message"/> 
    </div>
    <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8  2xl:col-span-2 text-sm">
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
        <div class="flex justify-end md:object-right">
          <Link :href="route('tipo-solucion.create')" label="Crear">
            <Button icon="pi pi-plus" label="Crear" raised />
          </Link>
        </div>
      </div>
      <div class="py-10">
        <DataTableComponent
        :data="TipoSolucion"
        :columns="tableColumns"
        :perPage="6"
        @delete="deleteRow"
        :showButtonDelete="showButton"
        @edit="editRow"
        :showButtonEdit="showButton"
      >
      </DataTableComponent>
      </div>
      
  
      <Dialog
        v-model:visible="visible"
        modal
        header="Detalles"
        :style="{ width: '50vw' }"
        :breakpoints="{ '960px': '75vw', '641px': '100vw' }"
      >
      <div class="flex justify-center items-center">
      <Image
        :src="imagenUrl"
        alt="Image"
        width="150"
        preview
      />
    </div>
  
        <div class="mb-6">
          <label
            for="nombre"
            class="block mb-3 text-sm font-medium text-gray-900 dark:text-gray-800"
            >Nombre</label
          >
          <input
            type="text"
            v-model="selectedRow.nombre"
            id="nombre"
            name="nombre"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            placeholder="Nombre"
          />
        </div>
  
        <div class="mb-6">
          <label
            for="estado"
            class="block mb-3 text-sm font-medium text-gray-900 dark:text-gray-800"
            >Estado</label
          >
          <input
            type="text"
            v-model="selectedRow.estado"
            id="estado"
            name="estado"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            placeholder="Estado"
          />
        </div>
        <template #footer>
          <Button label="Cerrar" icon="pi pi-times" @click="visible = false" text />
        </template>
      </Dialog>
    </div>
   
  </AuthenticatedLayout>
</template>


      <script setup>
import DataTableComponent from "@/Components/TablePrimeVue.vue";
import { ref, computed, onMounted } from "vue";
import { Head, useForm, Link } from "@inertiajs/inertia-vue3";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Notification from "@/Components/Notification.vue";

const form = useForm({});

const props = defineProps(["tipoSolucion", "tableColumns"]);
//console.log(props.tipoSolucion);
const id = ref();

const nombreFilter = ref("");

const TipoSolucion = computed(() => {
  if (!nombreFilter.value) {
    return props.tipoSolucion;
  }
  const filter = nombreFilter.value.toLowerCase();
  return props.tipoSolucion.filter(
    (item) =>
      item.nombre.toLowerCase().includes(filter) ||
      item.estado.toLowerCase().includes(filter)
  );
});

const applyFilter = () => {};

const showButton = ref(true);

const toggleButton = () => {
  showButton.value = !showButton.value;
};

const editRow = (rowData) => {
  //console.log("tipo-solucion.edit", rowData);
  form.get(route("tipo-solucion.edit", rowData));
};

const deleteRow = (rowId) => {
  //console.log("Delete row with ID:", rowId);
  form.delete(route("tipo-solucion.destroy", rowId));
};

const visible = ref(false);

const selectedRow = ref({
  id: "",
  nombre: "",
  estado: "",
});
//console.log(selectedRow);

const showRow = (rowId) => {
  //console.log("Aceptar row with ID:", rowId);
  selectedRow.value.id = rowId.id;
  //console.log(selectedRow.value.id);
  selectedRow.value.nombre = rowId.nombre;
  selectedRow.value.estado = rowId.estado;
  visible.value = true;
};

const imagenUrl = ref('');


onMounted(() => {
  import('@/Pages/TipoSolucion/Escudo_de_Puno.png')
    .then(module => {
      imagenUrl.value = module.default;
    })
    .catch(error => {
      console.error('Error cargando la imagen:', error);
    });
});

</script>



