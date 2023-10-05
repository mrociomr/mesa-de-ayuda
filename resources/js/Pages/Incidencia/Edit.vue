<script setup>
import { ref, defineProps } from "vue";
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from '@inertiajs/inertia-vue3'

const props = defineProps({
  incidencia: Object,
  oficinas: Array,
  tiposProblema: Array,
});

const form = useForm({
  dni: props.incidencia.dni,
  celular: props.incidencia.celular,
  tipo_problema_id: props.incidencia?.tipo_problema?.id,
  oficina_id: props.incidencia.oficina?.id,
});

const updateForm = () => {
    form.put(`/incidencia/${props.incidencia.id}`);
};
</script>
<template>
  <AuthenticatedLayout>
    <Head title="Editar Incidencia" />

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="card flex justify-content-center">
              <Link :href="route('incidencia.index')">
                <Button
                icon="pi pi-angle-left" 
                label="Atrás" text />
              </Link>
             </div>
            <p class="text-xl text-center font-semibold text-gray-600 py-4 uppercase">Editar incidencia</p>
            <form @submit.prevent="updateForm" class="mt-6 space-y-6">
              <div class="mb-6">
                <label
                  for="dni"
                  class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                  >DNI</label
                >
                <input
                  type="text"
                  v-model="form.dni"
                  id="dni"
                  name="dni"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  placeholder="Numero DNI"
                />
                <div v-if="form.errors.dni" class="text-sm text-red-600">
                  {{ form.errors.dni }}
                </div>
              </div>

              <div class="mb-6">
                <label
                  for="celular"
                  class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                  >Celular</label
                >
                <input
                  type="text"
                  v-model="form.celular"
                  id="celular"
                  name="celular"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  placeholder="Numero Celular"
                />
                <div v-if="form.errors.celular" class="text-sm text-red-600">
                  {{ form.errors.celular }}
                </div>
              </div>

              <div class="mb-6">
                <label
                  for="oficina_id"
                  class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                  >Oficina</label
                >
                <!--
                   <v-select
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  :options="oficinas"
                  label="abreviatura"
                  v-model="form.oficina_id"
                  :value="form.oficina_id"
                  :reduce="(tipo) => tipo.id"
                ></v-select>
                -->
                <Dropdown
                v-model="form.oficina_id"
                :options="oficinas"
                optionLabel="nombre"
                optionValue="id"
                placeholder="Seleccione una opción"
                class="w-full md:w-14rem"
                showClear />

                <div v-if="form.errors.oficina_id" class="text-sm text-red-600">
                  {{ form.errors.oficina_id }}
                </div>
              </div>

              <!-- Other input fields... -->

              <div class="mb-6">
                <label
                  for="tipo_problema_id"
                  class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                  >Tipo de Problema</label
                >
                <!--
                  <v-select
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  :options="tiposProblema"
                  label="nombre"
                  v-model="form.tipo_problema_id"
                  :value="form.tipo_problema_id"
                  :reduce="(tipo) => tipo.id"
                ></v-select>
                -->
                <Dropdown
                v-model="form.tipo_problema_id"
                :options="tiposProblema"
                optionLabel="nombre"
                optionValue="id"
                placeholder="Seleccione una opción"
                class="w-full md:w-14rem"
                showClear />

                <div v-if="form.errors.tipo_problema_id" class="text-sm text-red-600">
                  {{ form.errors.tipo_problema_id }}
                </div>
              </div>
              <div class="flex">
                <button
                type="submit"
                class="text-white bg-blue-500 focus:outline-none font-bold rounded-lg text-base px-5 py-2.5 ml-auto transform hover:scale-105 transition duration-300"
                :disabled="form.processing"
                :class="{ 'opacity-25': form.processing }"
              >
                Guardar
              </button>
              </div>
              
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>


