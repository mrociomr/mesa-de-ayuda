<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
  keysMensaje: Object,
});

console.log(props.keysMensaje);

const form = useForm({
  name: props.keysMensaje.name,
  number_key: props.keysMensaje.number_key,
});

//console.log(props.dependencias.id);

const updateform = () => {
  form.put(`/key-mensaje/${props.keysMensaje.id}`);
};  
</script>
<template>
  <AuthenticatedLayout>
    <Toast message="Nueva Key creada" />
    <Head title="Editar Key" />
    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="card flex justify-content-center">
              <Link :href="route('key-mensaje.index')">
                <Button icon="pi pi-angle-left" label="Atrás" text />
              </Link>
            </div>
            <p
              class="text-xl text-center font-semibold text-gray-600 py-4 uppercase"
            >
              Crear nueva key
            </p>
            <form @submit.prevent="updateform" class="mt-6 space-y-6">
              <div class="mb-6">
                <label
                  for="nombre"
                  class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                  >Nombre Usuario</label
                >
                <input
                  type="text"
                  v-model="form.name"
                  id="name"
                  name="name"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  placeholder="Ingrese un nombre"
                  autofocus
                />
                <div
                  v-if="$page.props.errors.name"
                  class="text-sm text-red-600"
                >
                  {{ $page.props.errors.name }}
                </div>
              </div>
              <div class="mb-6">
                <label
                  for="nombre"
                  class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                  >Key Usuario</label
                >
                <input
                  type="text"
                  v-model="form.number_key"
                  id="number_key"
                  name="number_key"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  placeholder="Ingrese una Key"
                  autofocus
                />
                <div
                  v-if="$page.props.errors.number_key"
                  class="text-sm text-red-600"
                >
                  {{ $page.props.errors.number_key }}
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
