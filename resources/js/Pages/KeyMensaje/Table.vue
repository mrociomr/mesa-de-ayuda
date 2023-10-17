<template>
    <Head title="Key Mensajes" />

    <AuthenticatedLayout>
      <div v-if="$page.props.flash.message" class="fixed z-50 top-4 right-4">
        <Notification :message="$page.props.flash.message" />
      </div>
      <div class="bg-white shadow rounded-lg p-4 sm:p-2 xl:p-8 2xl:col-span-2 text-sm">
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
          <Link :href="route('key-mensaje.create')">
            <Button icon="pi pi-plus" label="Crear" raised />
          </Link>
          </div>
        </div>
        <div class="py-10">
          <DataTableComponent
          :data="KeyMensajes"
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

  const props = defineProps(["keyMensaje", "tableColumns"]);

  const nombreFilter = ref("");

  const KeyMensajes = computed(() => {
    if (!nombreFilter.value) {
      return props.keyMensaje;
    }
    const filter = nombreFilter.value.toLowerCase();
    return props.keyMensaje.filter((item) =>
      item.name.toLowerCase().includes(filter)
    );
  });

  const applyFilter = () => {};

  const showButton = ref(true);

  const toggleButton = () => {
    showButton.value = !showButton.value;
  };

  const editRow = (rowData) => {
      //console.log("dependencia.edit", rowData);
    form.get(route("key-mensaje.edit",rowData))
  };

  const deleteRow = (rowId) => {
    //console.log("Delete row with ID:", rowId);
    form.delete(route("key-mensaje.destroy", rowId));
  };

  </script>
