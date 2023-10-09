<script setup>
import { ref, defineProps } from "vue";
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from '@inertiajs/inertia-vue3'

const props = defineProps({
  oficina: Object,
  sede: Array,
  dependencia: Array,
  passwordOriginal: String,
});

const form = useForm({
  nombre: props.oficina.nombre,
  abreviatura: props.oficina.abreviatura,
  nivel: props.oficina.nivel,
  prioridad: props.oficina.prioridad,
  estado: props.oficina.estado,
  sede_id: props.oficina.sede.id,
  dependencia_id: props.oficina.dependencia.id,
  password : props.passwordOriginal,
});

const estados = ref([ 'Activo' ,'Inactivo']);

const updateForm = () => {
    form.patch(`/oficina/${props.oficina.id}}}`);
};
</script>
<template>
  <AuthenticatedLayout>
    <Head title="Editar oficina" />

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
            <p class="text-xl text-center font-semibold text-gray-600 py-4 uppercase">Editar oficina</p>
            <form @submit.prevent="updateForm">
              <div class="grid grid-cols-2 gap-2">
                <div class="mb-6">
                  <label
                    for="nombre"
                    class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
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

                <!-- DESDE AQUI -->

                <div class="mb-6">
                  <label
                    for="sede_id"
                    class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                    >Sede</label
                  >
                 <!--
                  <v-select
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    :options="sede"

                    label="nombre"
                    v-model="form.sede_id"
                    :value="form.sede_id"
                    :reduce="(tipo) => tipo.id"
                  ></v-select>
                 -->
                 <Dropdown
                 v-model="form.sede_id"
                 :options="sede"
                 optionLabel="nombre"
                 optionValue="id"
                 placeholder="Seleccione una sede"
                 class="w-full md:w-14rem"
                 showClear />

                  <div v-if="form.errors.sede_id" class="text-sm text-red-600">
                    {{ form.errors.sede_id }}
                  </div>
                </div>
                <!--
                <div class="mb-6">
                  <label
                    for="sede_id"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                    >Sede</label
                  >
                  <v-select
                  :options="sede"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"

                    label="nombre"
                    v-model="form.sede_id"
                    :value="form.sede_id"
                    :reduce="(tipo) => tipo.id"
                  ></v-select>
                  <div v-if="form.errors.sede_id" class="text-sm text-red-600">
                    {{ form.errors.sede_id }}
                  </div>
                </div>
                 HASTA AQUI-->
                <!-- Other input fields... -->

                <div class="mb-6">
                  <label
                    for="dependencia_id"
                    class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                    >Dependencia</label
                  >
                  <Dropdown
                    v-model="form.dependencia_id"
                    :options="dependencia"
                    optionLabel="nombre"
                    optionValue="id"
                    placeholder="Seleccione una dependencia"
                    class="w-full md:w-14rem"
                    showClear />
                  <!--
                    <v-select
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    :options="dependencia"

                    label="nombre"
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
                    for="password"
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
