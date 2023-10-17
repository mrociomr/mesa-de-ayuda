<script setup>
import { ref, defineProps } from "vue";
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";

const showInput = ref(false);
const toggleInput = () => {
  showInput.value = !showInput.value;
};

const props = defineProps({
  solucion: Object,
  tipoSolucion: Array,
  rowsId: String,
  user: Array,
});
console.log(props.user);

const form = useForm({
  descripcion: null,
  estado: null,
  tipo_solucion_id: null,
  equipos: null,
  atendido_por: props.user.name,
  incidencias_id: props.rowsId,
});

const estados = ref(["Atendido", "Rechazado"]);

const createForm = () => {
  form.post(route("solucion.store"));
};
</script>
<template>
  <AuthenticatedLayout>
    <Head title="Registrar Solución" />

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="card flex justify-content-center">
              <Link :href="route('incidencia.index')">
                <Button icon="pi pi-angle-left" label="Atrás" text />
              </Link>
            </div>
            <p
              class="text-xl text-center font-semibold text-gray-600 py-4 uppercase"
            >
              Registrar solución
            </p>
            <form @submit.prevent="createForm" class="mt-6 space-y-6">
              <div class="mb-6">
                <input
                  type="text"
                  v-if="showInput"
                  v-model="form.solucion_id"
                  id="solucion_id"
                  name="solucion_id"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  placeholder="Solucion"
                />
              </div>

              <div class="mb-6">
                <label
                  for="equipo_id"
                  class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2 font-sans"
                  >Equipo</label
                >
                <input
                  type="text"
                  v-model="form.equipos"
                  id="equipos"
                  name="equipos"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  placeholder="Ingrese el código patrimonial"
                />
                <!--
                  <v-select
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  :options="equipo"
                  label="codigop"
                  v-model="form.equipo_id"
                  :value="form.equipo_id"
                  :reduce="(tipo) => tipo.id"
                ></v-select>
                -->

                <div v-if="form.errors.equipo_id" class="text-sm text-red-600">
                  {{ form.errors.equipo_id }}
                </div>
              </div>
              <div class="mb-6">
                <label
                  for="tipo_solucion_id"
                  class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2 font-sans"
                  >Tipo de Solución</label
                >
                <Dropdown
                  v-model="form.tipo_solucion_id"
                  :options="tipoSolucion"
                  optionLabel="nombre"
                  optionValue="id"
                  placeholder="Seleccione una solución"
                  class="w-full md:w-14rem"
                  showClear
                  editable
                />
                <!--
                  <v-select
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  :options="tipoSolucion"
                  label="nombre"
                  v-model="form.tipo_solucion_id"
                  :value="form.tipo_solucion_id"
                  :reduce="(tipo) => tipo.id"
                ></v-select>
                -->

                <div
                  v-if="form.errors.tipo_solucion_id"
                  class="text-sm text-red-600"
                >
                  {{ form.errors.tipo_solucion_id }}
                </div>
              </div>
              <div class="mb-6">
                <label
                  for="descripcion"
                  class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2 font-sans"
                  >Descripción</label
                >
                <!--
                  <input
                  type="text"
                  v-model="form.descripcion"
                  id="descripcion"
                  name="descripcion"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  placeholder="Ingrese una descripción"
                />
                -->
                <Textarea
                  v-model="form.descripcion"
                  id="descripcion"
                  name="descripcion"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-sans"
                  rows="3"
                  cols="30"
                  placeholder="Ingrese una descripción..."
                />

                <div
                  v-if="form.errors.descripcion"
                  class="text-sm text-red-600"
                >
                  {{ form.errors.descripcion }}
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
                  :reduce="(tipo) => tipo.id"
                  placeholder="Seleccione una opción"
                  class="w-full md:w-14rem"
                />
                <div v-if="form.errors.estado" class="text-sm text-red-600">
                  {{ form.errors.estado }}
                </div>
              </div>
              <div class="mb-6">
                <label
                  for="atendido_por"
                  class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2 font-sans"
                  >Atendido Por</label
                >
                <!-- v-if="showInput" -->
                <input
                  type="text"
                  v-model="form.atendido_por"
                  id="atendido_por"
                  name="atendido_por"
                  class="bg-gray-50 border border-gray-300 cursor-not-allowed text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  placeholder="Ingrese el código patrimonial"
                  readonly
                />
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


