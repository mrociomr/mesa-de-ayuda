<script setup>
import { ref, defineProps } from "vue";
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from '@inertiajs/inertia-vue3'


const props = defineProps({
  tipoSolucion: Object,
});

const form = useForm({
  nombre: null,
  estado: null,
});

const estados = ref([ 'Activo' ,'Inactivo']);

const createForm = () => {
  form.post(route('tipo-solucion.store'));
};
</script>
<template>
  <AuthenticatedLayout>
    <Head title="Crear tipo de solución" />

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="card flex justify-content-center">
              <Link :href="route('tipo-solucion.index')">
                <Button
                icon="pi pi-angle-left" 
                label="Atrás" text />
              </Link>
             </div>
            
            <p class="text-xl text-center font-semibold text-gray-600 py-4 uppercase">Crear nuevo tipo de solución</p>
            <form @submit.prevent="createForm" class="mt-6 space-y-6">
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
                  for="estado"
                  class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                  >Estado</label
                >
                <Dropdown
                  v-model="form.estado"
                  :options="estados"
                  placeholder="Seleccione un estado"
                  class="w-full md:w-14rem"
                />
                <div v-if="form.errors.estado" class="text-sm text-red-600">
                  {{ form.errors.estado }}
                </div>
              </div>
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


