<script setup>
import { ref, defineProps } from "vue";
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from '@inertiajs/inertia-vue3'

const props = defineProps({
  user: Object,
  roles: Array,
});

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  password: props.user.password,
  role_id: props.user.role_id,
});

const updateForm = () => {
    form.patch(`/oficina/${props.oficina.id}}}`);
};
</script>
<template>
  <AuthenticatedLayout>
    <Head title="Editar usuario" />

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="card flex justify-content-center">
              <Link :href="route('users.index')">
                <Button
                icon="pi pi-angle-left" 
                label="Atrás" text />
              </Link>
             </div>
            <p class="text-xl text-center font-semibold text-gray-600 py-4 uppercase">Editar usuario</p>
            <form @submit.prevent="updateForm" >
              <div class="grid grid-cols-2 gap-2">
                <div class="mb-6">
                  <label
                    for="name"
                    class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2 font-sans"
                    >Nombre</label
                  >
                  <input
                    type="text"
                    v-model="form.name"
                    id="name"
                    name="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Ingrese el nombre"
                  />
                  <div v-if="form.errors.name" class="text-sm text-red-600">
                    {{ form.errors.name }}
                  </div>
                </div>
  
                <div class="mb-6">
                  <label
                    for="email"
                    class="block uppercase tracking-wide text-gray-700 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                    >Email</label
                  >
                  <input
                    type="text"
                    v-model="form.email"
                    id="email"
                    name="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Ingrese el email"
                  />
                  <div v-if="form.errors.email" class="text-sm text-red-600">
                    {{ form.errors.email }}
                  </div>
                </div>
  
                <div class="mb-6">
                  <label
                    for="role_id"
                    class="block uppercase tracking-wide text-gray-900 text-xs after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                    >Rol</label
                  >
                  <MultiSelect 
                  v-model="form.role_id" 
                  display="chip" 
                  :options="roles" 
                  optionLabel="name" 
                  optionValue="id"
                  placeholder="Seleccione una o más opciones"
                  :maxSelectedLabels="3" 
                  class="w-full md:w-20rem" />
          
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
  
                  <div v-if="form.errors.role_id" class="text-sm text-red-600">
                    {{ form.errors.role_id }}
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


