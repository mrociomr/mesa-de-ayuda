<script setup>
import { ref, defineProps } from "vue";
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from '@inertiajs/inertia-vue3'

const props = defineProps({
  sedes: Object,
  estado: Array,
});

const form = useForm({
  nombre: null,
  direccion: null,
  latitud: null,
  longitud: null,
  descripcion: null,
  estado: null,
});

const estados = ref([ 'Activo' ,'Inactivo']);

const createForm = () => {
  form.post(route('sede.store'));
};
</script>
<template>
  <AuthenticatedLayout>
    <Head title="Crear Sede" />

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="card flex justify-content-center">
              <Link :href="route('sede.index')">
                <Button
                icon="pi pi-angle-left" 
                label="Atrás" text />
              </Link>
             </div>
            <p class="text-xl text-center font-semibold text-gray-600 py-4 uppercase">Crear nueva sede</p>
            <form @submit.prevent="createForm">
              <div class="grid grid-cols-2 gap-2">
                <div class="mb-6">
                  <label
                    for="nombre"
                    class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2 font-sans"
                    >Nombre</label
                  >
                  <input
                    type="text"
                    v-model="form.nombre"
                    id="nombre"
                    name="nombre"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Ingrese un nombre"
                  />
                  <div v-if="form.errors.nombre" class="text-sm text-red-600">
                    {{ form.errors.nombre }}
                  </div>
                </div>
  
                <div class="mb-6">
                  <label
                    for="direccion"
                    class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2 font-sans"
                    >Dirección</label
                  >
                  <input
                    type="text"
                    v-model="form.direccion"
                    id="direccion"
                    name="direccion"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Ingrese una dirección"
                  />
                  <div v-if="form.errors.direccion" class="text-sm text-red-600">
                    {{ form.errors.direccion }}
                  </div>
                </div>
  
                <div class="mb-6">
                  <label
                    for="latitud"
                    class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2 font-sans"
                    >Latitud</label
                  >
                  <input
                    type="text"
                    v-model="form.latitud"
                    id="latitud"
                    name="latitud"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Ingrese una latitud"
                  />
                  <div v-if="form.errors.latitud" class="text-sm text-red-600">
                    {{ form.errors.latitud }}
                  </div>
                </div>
                
                <div class="mb-6">
                  <label
                    for="longitud"
                    class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2 font-sans"
                    >Longitud</label
                  >
                  <input
                    type="text"
                    v-model="form.longitud"
                    id="longitud"
                    name="longitud"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Ingrese una longitud"
                  />
                  <div v-if="form.errors.longitud" class="text-sm text-red-600">
                    {{ form.errors.longitud }}
                  </div>
                </div>
                <div class="mb-6">
                  <label
                    for="estado"
                    class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2 font-sans"
                    >Estado</label
                  >
                 
                  <Dropdown
                  v-model="form.estado"
                  :options="estados"
                  placeholder="Seleccione un estado"
                  class="w-full md:w-14rem"
                  showClear
                />
                  <div v-if="form.errors.estado" class="text-sm text-red-600">
                    {{ form.errors.estado }}
                  </div>
                </div>
  
                <div class="mb-6">
                  <label
                    for="descripcion"
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
                    >Descripción</label
                  >
                  <Textarea v-model="form.descripcion" 
                    id="descripcion"
                    name="descripcion"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-sans"
                    rows="3" cols="30"
                    placeholder="Ingrese una descripción..." />
                  
                  <div v-if="form.errors.descripcion" class="text-sm text-red-600">
                    {{ form.errors.descripcion }}
                  </div>
                </div>
              </div>
              
              <!-- Other input fields... -->
              <div class="flex">
                <button
                type="submit"
                class="text-white bg-blue-500 focus:outline-none font-bold rounded-lg text-base px-5 py-2.5 ml-auto transform hover:scale-105 transition duration-300"
                :disabled="form.processing"
                :class="{ 'opacity-25': form.processing }"
              >
                Crear
              </button>
              </div>
              
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>


