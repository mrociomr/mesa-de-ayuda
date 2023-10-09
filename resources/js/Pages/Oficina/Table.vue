<template>
    <Head title="Oficinas" />
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
              <Link :href="route('oficina.create')">
                <Button label="Crear"
                icon="pi pi-plus"
                raised />
              </Link>
            </div>
          </div>
          <div class="py-10">
            <DataTableComponent
          :data="Oficina"
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
              for="sede"
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
              >Sede</label
            >
            <input
              type="text"
              v-model="selectedRow.sede"
              id="sede"
              name="sede"
              class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full p-2.5 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none cursor-not-allowed"
              disabled
            />
          </div>
          <div class="mb-6">
            <label
              for="dependencia"
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
              >Dependencia</label
            >
            <input
              type="text"
              v-model="selectedRow.dependencia"
              id="dependencia"
              name="dependencia"
              class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full p-2.5 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none cursor-not-allowed"
              disabled
            />
          </div>
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
              for="abreviatura"
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
              >Abreviatura</label
            >
            <input
              type="text"
              v-model="selectedRow.abreviatura"
              id="abreviatura"
              name="abreviatura"
              class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full p-2.5 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none cursor-not-allowed"
              disabled
            />
          </div>
          <div class="mb-6">
            <label
              for="nivel"
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
              >Nivel</label
            >
            <input
              type="text"
              v-model="selectedRow.nivel"
              id="nivel"
              name="nivel"
              class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full p-2.5 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none cursor-not-allowed"
              disabled
            />
          </div>
          <div class="mb-6">
            <label
              for="prioridad"
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
              >Prioridad</label
            >
            <input
              type="text"
              v-model="selectedRow.prioridad"
              id="prioridad"
              name="prioridad"
              class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full p-2.5 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none cursor-not-allowed"
              disabled
            />
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

    const props = defineProps(["oficina", "tableColumns"]);
    //console.log(props.oficina);
    const id = ref();

    const nombreFilter = ref("");
    const Oficina = computed(() => {
      if (!nombreFilter.value) {
        return props.oficina;
      }
      const filter = nombreFilter.value.toLowerCase();
      return props.oficina.filter((item) =>
        item.nombre.toLowerCase().includes(filter)
        || item.abreviatura.toLowerCase().includes(filter)
      );
    });

    const applyFilter = () => {};

    const showButton = ref(true);

    const toggleButton = () => {
      showButton.value = !showButton.value;
    };

    const editRow = (rowData) => {
        //console.log("oficina.edit", rowData);
      form.get(route("oficina.edit",rowData))
    };

    const deleteRow = (rowId) => {

      //console.log("Delete row with ID:", rowId);
      form.delete(route("oficina.destroy", rowId));
    };

    const visible = ref(false);

    const selectedRow = ref({
      id: "",
      nombre: "",
      abreviatura: "",
      nivel: "",
      prioridad: "",
      estado: "",
      created_at: "",
      updated_at: "",
      sede_id: "",
      dependencia_id: "",
    });


    const showRow = (rowId) => {
      //console.log("Aceptar row with ID:", rowId);
      selectedRow.value.id = rowId.id;
      //console.log(selectedRow.value.id);
      selectedRow.value.nombre = rowId.nombre;
      selectedRow.value.abreviatura = rowId.abreviatura;
      selectedRow.value.nivel = rowId.nivel;
      selectedRow.value.prioridad = rowId.prioridad;
      selectedRow.value.estado = rowId.estado;
      selectedRow.value.sede_id = rowId.sede.nombre;
      selectedRow.value.dependencia_id = rowId.dependencia.nombre;
      visible.value = true;
  };
  </script>
