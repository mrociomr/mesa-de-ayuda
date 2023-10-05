<template>
    <div class="card">
      <DataTable
        :value="data"
        :filters="filters"
        paginator
        :rows="5"
        :rowsPerPageOptions="[5, 10, 20, 50]"
      >
        <Column
          sortable
          style="width: auto"
          v-for="column in columns"
          :key="column.key"
          :field="column.key"
          :header="column.label"
        />
        <Column header="Acciones">
          <template #body="slotProps">
            <Button
              v-if="showButtonEdit"
              label="Editar"
              icon="pi pi-pencil"
              @click="editRow(slotProps.data)"
              size="small"
              severity="success"

              raised
            ></Button>
            <Button
              v-if="showButtonDelete"
              label="Eliminar"
              icon="pi pi-trash"
              @click="deleteRow(slotProps.data.id)"
              size="small"
              severity="danger"
              raised
            ></Button>
            <Button
              v-if="showButtonSolution"
              label="Solucionar"
              icon="pi pi-arrow-circle-right"
              @click="solutionRow(slotProps.data.id)"
              size="small"
              severity="help"
              raised
            ></Button>
            <Button
              v-if="showButtonView"
              label="Detalle"
              icon="pi pi-eye"
              @click="viewRow(slotProps.data)"
              size="small"
              severity="warning"
              raised
            ></Button>
          </template>
        </Column>
      </DataTable>
    </div>
  </template>

    <script setup>
  import { defineProps, defineEmits, ref } from "vue";
  import Swal from 'sweetalert2';

  const visible = ref(false);

  const { data, columns, filters, showButton } = defineProps([
    "data",
    "columns",
    "filters",
    "showButtonEdit",
    "showButtonDelete",
    "showButtonSolution",
    "showButtonView"
  ]);

  const emit = defineEmits(["edit", "delete", "solution", "view"]);

  const editRow = (rowData) => {
    
    emit("edit", rowData);
  };

  const deleteRow = (rowId) => {
   
    Swal.fire({
    title: '¿Estás seguro?',
    text: "¡No podrás revertir esta acción!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '¡Si, elimínalo!',
    cancelButtonText: 'Cancelar'
    }).then((result) => {
    if (result.isConfirmed) {
      emit("delete", rowId);
      Swal.fire(
        '¡Eliminado!',
        'EL registro fue eliminado',
        'success'
      )
  }
})
    
  };

  const solutionRow = (rowId) => {
    emit("solution", rowId);
  };

  const viewRow = (rowId) => {
      emit("view", rowId);
  }

  </script>
