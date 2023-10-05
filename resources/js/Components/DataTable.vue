<template>
    <!--
    <table>
      <thead>
        <tr>
          <th v-for="column in columns" :key="column.key">{{ column.label }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="row in data" :key="row.id">
          <td v-for="column in columns" :key="column.key">
            {{ row[column.key] }}
          </td>
        </tr>
      </tbody>

    </table>  -->
    <!-- tabla -->
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col"
            class="px-6 py-3"
            v-for="column in columns" :key="column.key" >
            {{ column.label }}
          </th>
          <th>
            Action
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="row in data" :key="row.id"
          class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          <td v-for="column in columns" :key="column.key"
            scope="row"
            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ row[column.key] }}
          </td>
          <td class="px-6 py-4">
            <Button type="cyan" @click="editRow(row)"><i class="fa-solid fa-edit"></i></Button>
            <Button type="red" @click="deleteRow(row.id)"><i class="fa-solid fa-trash"></i></Button>
          </td>
        </tr>
      </tbody>
    </table>
  </template>
  <script setup>
  import { defineProps, defineEmits } from "vue";
  import Button from "./Button.vue";

  const { data, columns } = defineProps(["data", "columns"]);

  const emit = defineEmits(["edit", "delete"]);

  const editRow = (row) => {
    emit("edit", [0,row]);
  };

  const deleteRow = (rowId) => {
    emit("delete", rowId);
  };
  </script>
