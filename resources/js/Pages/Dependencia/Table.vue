<template>
  <Head title="Dependencia" />

  <AuthenticatedLayout>
     <div v-if="$page.props.flash.message" class="fixed z-50 top-4 right-4">
      <Notification :message="$page.props.flash.message" />
    </div> 
    <div
      class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 2xl:col-span-2 text-sm"
    >
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
          <Link :href="route('dependencia.create')">
            <Button icon="pi pi-plus" label="Crear" raised />
          </Link>
        </div>
      </div>
      <div class="py-10">
        <DataTableComponent
          :data="Dependencia"
          :columns="tableColumns"
          :perPage="6"
          @delete="deleteRow"
          :showButtonDelete="showButton"
          @edit="editRow"
          :showButtonEdit="showButton"
        />
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

const props = defineProps(["dependencia", "tableColumns"]);

const nombreFilter = ref("");

const Dependencia = computed(() => {
  if (!nombreFilter.value) {
    return props.dependencia;
  }
  const filter = nombreFilter.value.toLowerCase();
  return props.dependencia.filter((item) =>
    item.nombre.toLowerCase().includes(filter)
  );
});

const applyFilter = () => {};

const showButton = ref(true);

const editRow = (rowData) => {
  //console.log("dependencia.edit", rowData);
  form.get(route("dependencia.edit", rowData));
};

const deleteRow = (rowId) => {
  //console.log("Delete row with ID:", rowId);
  form.delete(route("dependencia.destroy", rowId));
};
</script>







