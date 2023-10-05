<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from '@inertiajs/inertia-vue3'

const props = defineProps({
  tokenMensaje: Object,
});

const form = useForm({
  name_token: props.tokenMensaje.name_token,

});

//console.log(props.dependencias.id);

const updateform = () => {
  form.put(`/token-mensaje/${props.tokenMensaje.id}`);
};


</script>
<template>
  <AuthenticatedLayout>
    <Toast
    message="Nueva Token creada"
    />
    <Head title="Editar Token" />
    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
              <div class="card flex justify-content-center">
                <Link :href="route('token-mensaje.index')">
                  <Button
                  icon="pi pi-angle-left"
                  label="Atrás" text />
                </Link>
               </div>
            <p class="text-xl text-center font-semibold text-gray-600 py-4 uppercase">Crear nueva dependencia</p>
            <form @submit.prevent="updateform" class="mt-6 space-y-6">
              <div class="mb-6">
                <label
                  for="nombre"
                  class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                  >Token Unico</label
                >
                <input
                  type="text"
                  v-model="form.name_token"
                  id="nombre"
                  name="name_token"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  placeholder="Ingrese un nombre"
                  autofocus
                />
                <div v-if="$page.props.errors.name_token" class="text-sm text-red-600">
                  {{ $page.props.errors.name_token }}
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
