<template>
    <div>
      <label>Filtrar por Nombre:</label>
      <input v-model="filterValue" @input="filterData" />
    </div>
  </template>

  <script setup>
  import { ref, defineEmits } from 'vue';

  const filterValue = ref('');

  const { emit } = defineEmits();

  const filterData = () => {
    emit('filter', filterValue.value);
  };
  </script>

