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
              icon="pi pi-pencil"
              @click="editRow(slotProps.data)"
            ></Button>
            <Button
              icon="pi pi-trash"
              @click="deleteRow(slotProps.data.id)"
            ></Button>

          </template>
        </Column>
      </DataTable>
    </div>
</template>


<script setup>
import { defineProps, defineEmits, ref, onMounted } from "vue";

const { data, columns, filters } = defineProps(["data", "columns", "filters"]);

//const currentPage = ref(data.current_page);
//const perPage = ref(data.perpage);

const emit = defineEmits(["edit", "delete", "aceptar"]);

const editRow = (rowData) => {
console.log(rowData);
emit("edit", rowData);
};

const deleteRow = (rowId) => {
emit("delete", rowId);
};

const acept = (row) => {
emit("aceptar", row);
}


</script>
