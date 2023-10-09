<script setup>
import { ref, defineProps } from "vue";
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from '@inertiajs/inertia-vue3'

const props = defineProps({
  oficina: Object,
  sedes: Array,
  dependencias: Array,
  errors: Object,
});

const form = useForm({
  nombre: null,
  abreviatura: null,
  nivel: null,
  prioridad: null,
  estado: null,
  sede_id: null,
  dependencia_id: null,
  password: null
});
//console.log(form.dependencia_id)

const estados = ref([ 'Activo' ,'Inactivo']);


const createForm = () => {
  form.post(route('oficina.store'));
};


</script>
<template>
  <AuthenticatedLayout>
    <Head title="Crear Oficina" />

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="card flex justify-content-center">
              <Link :href="route('oficina.index')">
                <Button
                icon="pi pi-angle-left"
                label="Atrás" text />
              </Link>
             </div>
            <p class="text-xl text-center font-semibold text-gray-600 py-4 uppercase">Crear nueva oficina</p>
            <form @submit.prevent="createForm" >
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
                    for="abreviatura"
                    class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                    >Abreviatura</label
                  >
                  <input
                    type="text"
                    v-model="form.abreviatura"
                    id="abreviatura"
                    name="abreviatura"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Ingrese una abreviatura"
                  />
                  <div v-if="form.errors.abreviatura" class="text-sm text-red-600">
                    {{ form.errors.abreviatura }}
                  </div>
                </div>

                <div class="mb-6">
                  <label
                    for="nivel"
                    class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                    >Nivel (1 - 5)</label
                  >
                  <input
                    type="text"
                    v-model="form.nivel"
                    id="nivel"
                    name="nivel"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Ingrese un nivel"
                  />
                  <div v-if="form.errors.nivel" class="text-sm text-red-600">
                    {{ form.errors.nivel }}
                  </div>
                </div>

                <div class="mb-6">
                  <label
                    for="prioridad"
                    class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                    >Prioridad (1 - 5)</label
                  >
                  <input
                    type="text"
                    v-model="form.prioridad"
                    id="prioridad"
                    name="prioridad"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Ingrese una prioridad"
                  />
                  <div v-if="form.errors.prioridad" class="text-sm text-red-600">
                    {{ form.errors.prioridad }}
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
                    showClear
                  />
                  <div v-if="form.errors.estado" class="text-sm text-red-600">
                    {{ form.errors.estado }}
                  </div>
                </div>

                <div class="mb-6">
                  <label
                    for="sede_id"
                    class="block uppercase tracking-wide text-gray-900 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                    >Sede</label
                  >
                  <Dropdown
                  v-model="form.sede_id"
                  :options="sedes"
                  showClear
                  editable
                  optionLabel="nombre"
                  optionValue="id"
                  placeholder="Seleccione una sede"
                  class="w-full md:w-14rem" />
                  <!--
                <v-select
                    class="bg-gray-50 border-gray-300 md:w-14rem  text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    :options="sedes"
                    label="nombre"
                    v-model="form.sede_id"
                    :value="form.sede_id"
                    :reduce="(tipo) => tipo.id"
                    placeholder="Seleccione una opción"

                  ></v-select>
                  -->

                  <div v-if="form.errors.sede_id" class="text-sm text-red-600">
                    {{ form.errors.sede_id }}
                  </div>
                </div>

                <div class="mb-6">
                  <label
                    for="dependencia_id"
                    class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                    >Dependencia</label
                  >

                  <Dropdown
                  v-model="form.dependencia_id"
                  :options="dependencias"
                  showClear
                  editable
                  optionLabel="nombre"
                  optionValue="id"
                  placeholder="Seleccione una dependencia"
                  class="w-full md:w-14rem" />
                  <!--
                  <v-select
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    :options="dependencias"
                    label="nombre"
                    placeholder="Seleccione una opción"
                    v-model="form.dependencia_id"
                    :value="form.dependencia_id"
                    :reduce="(tipo) => tipo.id"
                  ></v-select>
                  -->

                  <div v-if="form.errors.dependencia_id" class="text-sm text-red-600">
                    {{ form.errors.dependencia_id }}
                  </div>
                </div>

                <div class="mb-6">
                  <label
                    for="password_id"
                    class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                    >Contraseña</label
                  >
                <div class="card flex justify-content-center">
                     <input
                    type="text"
                    v-model="form.password"
                    id="password"
                    name="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Ingrese una contraseña"
                  />
                  </div>

                  <div v-if="form.errors.password" class="text-sm text-red-600">
                    {{ form.errors.password }}
                  </div>
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
