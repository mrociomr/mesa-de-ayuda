<template>
  <Head title="Sedes" />
    <AuthenticatedLayout>
      <div v-if="$page.props.flash.message" class="fixed z-50 top-4 right-4">
        <Notification :message="$page.props.flash.message" />
      </div>
      <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8  2xl:col-span-2">
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
          <div class="flex justify-end md:object-right">
            <Link :href="route('sede.create')">
              <Button label="Crear"
              icon="pi pi-plus"
              raised />
            </Link>
          </div>
        </div>
        <div class="py-10">
          <DataTableComponent
        :data="Sede"
        :columns="tableColumns"
        :perPage="6"
        @delete="deleteRow"
        :showButtonDelete="showButton"
        @edit="editRow"
        :showButtonEdit="showButton"
        @view="showRow"
        :showButtonView="showButton"
      >
      </DataTableComponent>
      <Dialog
      v-model:visible="visible"
      modal
      header="Detalles"
      :style="{ width: '50vw' }"
      :breakpoints="{ '960px': '75vw', '641px': '100vw' }"
    >
    <div class="flex justify-center items-center">
  </div>
      <div class="grid grid-cols-2 gap-2">
        <div class="mb-6">
          <label
            for="nombre"
            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
            >Nombre</label
          >
          <input
            type="text"
            v-model="selectedRow.nombre"
            id="nombre"
            name="nombre"
            class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full p-2.5 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none cursor-not-allowed"
            disabled
          />
        </div>
        <div class="mb-6">
          <label
            for="direccion"
            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
            >Dirección</label
          >
          <input
            type="text"
            v-model="selectedRow.direccion"
            id="direccion"
            name="direccion"
            class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full p-2.5 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none cursor-not-allowed"
            disabled
          />
        </div>
        <div class="mb-6">
          <label
            for="latitud"
            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
            >Latitud</label
          >
          <input
            type="text"
            v-model="selectedRow.latitud"
            id="latitud"
            name="latitud"
            class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full p-2.5 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none cursor-not-allowed"
            disabled
          />
        </div>
        <div class="mb-6">
          <label
            for="longitud"
            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
            >Longitud</label
          >
          <input
            type="text"
            v-model="selectedRow.longitud"
            id="longitud"
            name="longitud"
            class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full p-2.5 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none cursor-not-allowed"
            disabled
          />
        </div>
        <div class="mb-6">
          <label
            for="descripcion"
            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
            >Descripción</label
          >
          <Textarea v-model="selectedRow.descripcion"
                  id="descripcion"
                  name="descripcion"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed"
                  rows="5" cols="30"
                  disabled />
        </div>
        <div class="mb-6">
          <label
            for="estado"
            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
            >Estado</label
          >
          <input
            type="text"
            v-model="selectedRow.estado"
            id="estado"
            name="estado"
            class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full p-2.5 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none cursor-not-allowed"
            disabled
          />
        </div>

        <div class="mb-6">
          <label
            for="created_at"
            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
            >Fecha de creación</label
          >
          <input
            type="datetime-local"
            v-model="selectedRow.created_at"
            id="created_at"
            name="created_at"
            class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full p-2.5 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none cursor-not-allowed"
            disabled
          />
        </div>
        <div class="mb-6">
          <label
            for="updated_at"
            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
            >Fecha de actualización</label
          >
          <input
            type="datetime-local"
            v-model="selectedRow.updated_at"
            id="updated_at"
            name="updated_at"
            class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full p-2.5 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none cursor-not-allowed"
            disabled
          />
        </div>

      </div>
      <template #footer>
        <Button label="Cerrar" icon="pi pi-times" @click="visible = false" text />
      </template>
    </Dialog>
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

  const props = defineProps(["sede", "tableColumns"]);
  //console.log(props.sede);
  const id = ref();

  const nombreFilter = ref("");
  const Sede = computed(() => {
    if (!nombreFilter.value) {
      return props.sede;
    }
    const filter = nombreFilter.value.toLowerCase();
    return props.sede.filter((item) =>
      item.nombre.toLowerCase().includes(filter)
    );
  });

  const applyFilter = () => {};

  const showButton = ref(true);



  const editRow = (rowData) => {
      //console.log("sede.edit", rowData);
    form.get(route("sede.edit",rowData))
  };

  const deleteRow = (rowId) => {

  /*  console.log("Delete row with ID:", rowId);
    Swal.fire({
    title: '¿Estás seguro?',
    text: "¡No podrás revertir esta acción!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '¡Si, elimínalo!'
    }).then((result) => {
    if (result.isConfirmed) {
      form.delete(route("sede.destroy", rowId));
      Swal.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success'
      )
  }
}) */

    //console.log("Delete row with ID:", rowId);
    form.delete(route("sede.destroy", rowId));
  };

  const visible = ref(false);

  const selectedRow = ref({
    id: "",
    nombre: "",
    direccion: "",
    latitud: "",
    longitud: "",
    descripcion: "",
    estado: "",
    created_at: "",
    updated_at: "",
  });
  //console.log(selectedRow);

  const showRow = (rowId) => {
    //console.log("Aceptar row with ID:", rowId);
    selectedRow.value.id = rowId.id;
    //console.log(selectedRow.value.id);
    selectedRow.value.nombre = rowId.nombre;
    selectedRow.value.direccion = rowId.direccion;
    selectedRow.value.estado = rowId.estado;
    selectedRow.value.latitud = rowId.latitud;
    selectedRow.value.longitud = rowId.longitud;
    selectedRow.value.descripcion = rowId.descripcion;
    selectedRow.value.created_at = rowId.created_at;
    selectedRow.value.updated_at = rowId.updated_at;
    visible.value = true;
};
</script>
