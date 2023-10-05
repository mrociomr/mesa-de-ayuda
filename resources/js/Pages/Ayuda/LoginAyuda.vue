<script setup>
import { ref, defineProps } from "vue";
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";


const props = defineProps({
  oficinas: Array,
});

const form = useForm({
  nombre: null,
  password: null,
});

const createForm = async () => {
  const response = await form.post(`/loginAyuda`);
  console.log(response);
};
</script>
<template>
  <Head title="Login" />
  <div
    class="min-h-screen flex justify-center bg-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-500 bg-no-repeat bg-cover relative items-center"
    style="
      background-image: url(https://ojoalclima.com/wp-content/uploads/2022/07/20-Lago-Titicaca.jpg);
    "
  >
    <div class="absolute bg-black opacity-60 inset-0 z-0"></div>
    <div
      class="max-w-md w-full space-y-8 p-10 bg-white rounded-xl shadow-lg z-10"
    >
      <div class="grid gap-8 grid-cols-1">
        <div class="flex flex-col">
          <div class="flex flex-col sm:flex-row items-center">
            <div class="w-12 h-12 mr-4 flex-none rounded-xl overflow-hidden">
              <img
                class="w-12 h-12 mr-4 object-cover"
                src="https://d1yjjnpx0p53s8.cloudfront.net/styles/logo-thumbnail/s3/112019/logo_de_puno.png?jy5cN0INfyAE7TX1YDj1_WmvJ24aj9wu&itok=vnbKVJP4"
                alt="Logo del municipio de Puno"
              />
            </div>
            <div class="text-center">
              <p class="font-semibold text-sm mr-auto">
                MUNICIPALIDAD PROVINCIAL DE PUNO
              </p>
              <p class="text-sm mr-auto">OFICINA DE TECNOLOGÍA INFORMÁTICA</p>
            </div>
          </div>
          <div class="mt-5">
            <div class="form">
              <div class="md:space-y-2 mb-3">
                <p class="text-sm text-center font-semibold text-gray-600">
                  INICIAR SESIÓN
                </p>
                <p class="text-xl text-center font-semibold text-gray-600">
                  MESA DE AYUDA
                </p>
              </div>
              <form @submit.prevent="createForm" class="mt-6 space-y-6">
                <!-- OFICINA -->
                <div class="mb-6">
                  <label
                    for="oficina_id"
                    class="block uppercase tracking-wide text-gray-700 text-sm after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                    >Oficina</label
                  >

                  <Dropdown
                    v-model="form.nombre"
                    :options="oficinas"
                    editable
                    showClear
                    optionLabel="nombre"
                    optionValue="nombre"
                    placeholder="Seleccione una oficina"
                    class="w-full md:w-14rem"
                  />

                  <div v-if="form.errors.nombre" class="text-sm text-red-600">
                    {{ form.errors.nombre }}
                  </div>
                </div>

                <!-- CONTRASEÑA -->
                <div class="mb-6">
                  <label
                    for="celular"
                    class="block uppercase tracking-wide text-gray-700 text-sm after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2"
                    >Contraseña
                  </label>
                  <input
                    type="text"
                    v-model="form.password"
                    id="password"
                    name="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Ingrese su contraseña"
                  />
                  <div v-if="form.errors.password" class="text-sm text-red-600">
                    {{ form.errors.password }}
                  </div>
                </div>

                <!--BOTÓN INGRESAR -->
                <div class="flex justify-end">
                  <button
                    type="submit"
                    class="mb-2 md:mb-0 bg-green-400 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-green-500"
                    :disabled="form.processing"
                    :class="{ 'opacity-25': form.processing }"
                  >
                    INGRESAR
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <Chatbot />
    </div>
  </div>
</template>


