<template>
    <div class="paginator">
      <span>Rows per page:</span>
      <select v-model="selectedRowsPerPage" @change="updateRowsPerPage">
        <option v-for="option in rowsPerPageOptions" :key="option" :value="option">{{ option }}</option>
      </select>
      <span>Page:</span>
      <button :disabled="currentPage === 1" @click="changePage(currentPage - 1)">Previous</button>
      <span>{{ currentPage }}</span>
      <button :disabled="currentPage === totalPages" @click="changePage(currentPage + 1)">Next</button>
    </div>
  </template>

  <script setup>
  import { ref, watch, onMounted, onBeforeUnmount, computed, defineProps, defineEmits } from 'vue';

  const { rows, rowsPerPage, currentPage } = defineProps(['rows', 'rowsPerPage', 'currentPage']);

  const rowsPerPageOptions = [10, 20, 50];

  const selectedRowsPerPage = ref(rowsPerPage);

  const totalPages = computed(() => Math.ceil(rows / selectedRowsPerPage));

  const updateRowsPerPage = () => {
    currentPage.value = 1;
    emit('update:rowsPerPage', selectedRowsPerPage);
  };

  const changePage = (newPage) => {
    if (newPage >= 1 && newPage <= totalPages.value) {
      currentPage.value = newPage;
      emit('update:currentPage', newPage);
    }
  };

  const emit = defineEmits();

  watch(() => rows, () => {
    if (currentPage.value > totalPages.value) {
      currentPage.value = totalPages.value;
    }
  });
  </script>
