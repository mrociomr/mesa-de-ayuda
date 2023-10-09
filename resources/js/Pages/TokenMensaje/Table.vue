<template>
    <Head title="Token" />

    <AuthenticatedLayout>
      <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8  2xl:col-span-2 text-sm">
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
          <!-- <div class="flex justify-end">
          <Link :href="route('token-mensaje.create')">
            <Button icon="pi pi-plus" label="Crear" raised />
          </Link>
          </div> -->
        </div>
        <div class="py-10">
          <DataTableComponent
          :data="TokenMensaje"
          :columns="tableColumns"
          :perPage="6"
          @delete="deleteRow"
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

  const form = useForm({});

  const props = defineProps(["tokenMensaje", "tableColumns"]);

  const nombreFilter = ref("");

  const TokenMensaje = computed(() => {
    if (!nombreFilter.value) {
      return props.tokenMensaje;
    }
    const filter = nombreFilter.value.toLowerCase();
    return props.tokenMensaje.filter((item) =>
      item.name_token.toLowerCase().includes(filter)
    );
  });

  const applyFilter = () => {};

  const showButton = ref(true);

  const toggleButton = () => {
    showButton.value = !showButton.value;
  };


  const editRow = (rowData) => {
      //console.log("dependencia.edit", rowData);
    form.get(route("token-mensaje.edit",rowData))
  };

  const deleteRow = (rowId) => {
    //console.log("Delete row with ID:", rowId);
    form.delete(route("token-mensaje.destroy", rowId));
  };

  </script>
