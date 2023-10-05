<template>
  <Head title="Tipos de Problemas" />

  <AuthenticatedLayout>
    <div v-if="$page.props.flash.message" class="fixed z-50 top-4 right-4">
      <Notification :message="$page.props.flash.message" />
    </div>
    <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8  2xl:col-span-2">
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
          <Link :href="route('tipo-problema.create')" label="Crear">
            <Button 
            icon="pi pi-plus"
            class="p-button-right"
            label="Crear" raised />
          </Link>
        </div>
        
  
      </div>
    <div class="py-10">
      <DataTableComponent
      :data="tipoProblema"
      :columns="tableColumns"
      :perPage="6"
      @edit="editRow"
      :showButtonEdit="showButton" 
      @delete="deleteRow"
      :showButtonDelete="showButton"
       
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

const props = defineProps(["tipoProblema", "tableColumns"]);
//console.log(props.tipoProblema);
const id = ref();

const nombreFilter = ref("");
const tipoProblema = computed(() => {
  if (!nombreFilter.value) {
    return props.tipoProblema;
  }
  const filter = nombreFilter.value.toLowerCase();
  return props.tipoProblema.filter((item) =>
    item.nombre.toLowerCase().includes(filter)
  );
});


const applyFilter = () => {};

const editingRow = ref(null);

const showButton = ref(true);

const toggleButton = () => {
  showButton.value = !showButton.value;
};

const editRow = (rowData) => {
    //console.log("tipo-problema.edit", rowData);
  form.get(route("tipo-problema.edit",rowData))
};
const deleteRow = (rowId) => {
  //console.log("Delete row with ID:", rowId);
  form.delete(route("tipo-problema.destroy", rowId));
};



</script>
