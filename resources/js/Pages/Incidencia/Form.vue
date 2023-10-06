<script setup>
import { ref, defineProps, computed } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Head } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";

const props = defineProps({
  dependencias: Object,
  oficinas: Array,
  tiposProblema: Array,
});

const form = useForm({
  id: null,
  dni: null,
  celular: null,
  tipo_problema_id: null,
  oficina_id: null,
  otros: null,
  message: null,
});

const dninum = form.dni;
console.log(dninum);
const ConfirmDialog = () => {
  Swal.fire({
    title: "¿Está seguro que quiere enviar?",
    text: "",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "¡Si, quiero enviar!",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    form.post(route("ayuda.store"));

    if (result.isConfirmed) {
      if (!form.errors) {
        Swal.fire(
          "Error",
          "Por favor, corrija los errores en el formulario antes de enviar.",
          "error"
        );
      } else {
        Swal.fire(
          "Se envió correctamente",
          `Su número de ticket es: ${form.id}`,
          "success"
        );
      }
    }
  });
};

const areCamposRequeridosLlenos = () => {
  return form.dni && form.celular && form.oficina_id && form.tipo_problema_id;
};

/*const datosCompletos = computed(() => {
  return `DNI: ${form.dni}, Celular: ${form.celular},
  Oficina: ${props.oficinas.nombre},
  Tipo de Problema: ${form.tipo_problema_id}, Otros: ${form.otros}`;
});*/
const datosCompletos = computed(() => {
  // const now = new Date();
  // const horaActual = `${now.getHours()}:${now.getMinutes()}:${now.getSeconds()}`;
  const now = new Date();
  const hora = now.getHours();
  const minutos = now.getMinutes();
  const amOrPm = hora >= 12 ? "PM" : "AM";
  const horaActual = `${hora > 12 ? hora - 12 : hora}:${
    minutos < 10 ? "0" : ""
  }${minutos} ${amOrPm}`;

  const oficinaSeleccionada = form.oficina_id
    ? props.oficinas.find((oficina) => oficina.id === form.oficina_id).nombre
    : "No seleccionada";
  const tipoProblemaSeleccionado = form.tipo_problema_id
    ? props.tiposProblema.find((tipo) => tipo.id === form.tipo_problema_id)
        .nombre
    : "No seleccionado";
  return `DNI: ${form.dni},
Numero de Celular: ${form.celular},
Oficina: ${oficinaSeleccionada},
Tipo de Problema: ${tipoProblemaSeleccionado},
Otros: ${form.otros ? form.otros : ""},
Hora Actual: ${horaActual}`;
});

form.message = datosCompletos;
console.log(form.message);

const mostrarInput = ref(false);

const toggleInput = () => {
  mostrarInput.value = !mostrarInput.value; // Cambia el estado de mostrarInput
};

const submitForms = () => {
  if (areCamposRequeridosLlenos()) {
    form.post(`/ayuda`);
  } else {
    console.log("Completar campos");
  }
};

//  function showOtrosTextarea() {

//      return this.form.tipo_problema_id === 2;
//    };
</script>
<template>
  <Head title="Mesa de Ayuda" />
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
                class="w-10 h-15 mr-4 object-cover"
                src="/images/Escudo_de_Puno.png" 
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
                <p class="text-xs text-center text-gray-400">
                  ¡Bienvenido(a) a la mesa de ayuda!
                </p>
                <p class="text-xl text-center font-semibold text-gray-600">
                  REGISTRE SU INCIDENCIA
                </p>
              </div>
              <form @submit.prevent="submitForms" class="mt-6 space-y-6">
                <!-- DNI -->
                <div class="mb-6">
                  <label
                    for="dni"
                    class="block uppercase tracking-wide text-sm after:content-['*'] after:ml-0.5 after:text-red-500 text-gray-700 font-bold mb-2 font-sans"
                    >DNI</label
                  >

                  <input
                    type="text"
                    v-model="form.dni"
                    id="dni"
                    name="dni"
                    icon="heroicons-phone"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Ingrese su número de DNI"
                    maxlength="8"
                  />

                  <div v-if="form.errors.dni" class="text-sm text-red-600">
                    {{ form.errors.dni }}
                  </div>
                </div>
                <!-- CELULAR -->
                <div class="mb-6">
                  <label
                    for="celular"
                    class="block uppercase tracking-wide text-gray-700 text-sm after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2 font-sans"
                    >Celular</label
                  >
                  <input
                    type="text"
                    v-model="form.celular"
                    id="celular"
                    name="celular"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Ingrese su número de celular"
                    maxlength="9"
                  />
                  <div v-if="form.errors.celular" class="text-sm text-red-600">
                    {{ form.errors.celular }}
                  </div>
                </div>
                <!-- OFICINA -->

                <div class="mb-6">
                  <label
                    for="oficinas"
                    class="block uppercase tracking-wide after:content-['*'] after:ml-0.5 after:text-red-500 text-gray-700 text-sm font-bold mb-2 font-sans"
                    >Oficina</label
                  >
                  <!-- <v-select
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                          :options="oficinas"
                          label="nombre"
                          v-model="form.oficina_id"
                          :value="form.oficina_id"
                          :reduce="(tipo) => tipo.id"
                          placeholder="Seleccione una opción"
                        ></v-select> -->

                  <div class="card flex justify-content-center">
                    <Dropdown
                      v-model="form.oficina_id"
                      :options="oficinas"
                      editable
                      showClear
                      optionLabel="nombre"
                      optionValue="id"
                      placeholder="Seleccione su oficina"
                      class="w-full md:w-14rem"
                    />
                  </div>
                  <div
                    v-if="form.errors.oficina_id"
                    class="text-sm text-red-600"
                  >
                    {{ form.errors.oficina_id }}
                  </div>
                </div>
                <!-- TIPO DE PROBLEMA -->
                <div class="mb-6">
                  <label
                    for="tiposProblema"
                    class="block uppercase tracking-wide text-gray-700 text-sm after:content-['*'] after:ml-0.5 after:text-red-500 font-bold mb-2 font-sans"
                    >Tipo de Problema</label
                  >

                  <div class="card flex justify-content-center">
                    <Dropdown
                      v-model="form.tipo_problema_id"
                      :options="tiposProblema"
                      showClear
                      optionLabel="nombre"
                      optionValue="id"
                      placeholder="Seleccione su tipo de problema"
                      class="w-full md:w-14rem"
                    />
                  </div>

                  <div class="py-4">
                    <Textarea
                      v-if="form.tipo_problema_id === 17"
                      v-model="form.otros"
                      placeholder="Ingrese el detalle de su problema"
                      class="w-full md:w-14rem"
                    />
                  </div>

                  <div
                    v-if="form.errors.tipo_problema_id"
                    class="text-sm text-red-600"
                  >
                    {{ form.errors.tipo_problema_id }}
                  </div>
                </div>

                <div class="mb-6">
                  <!-- <input
                    type="text"
                    :placeholder="datosCompletos"
                    v-model="datosCompletos"
                    id="datos"
                    name="datos"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    readonly
                  /> -->
                  <Textarea
                    v-if="mostrarInput"
                    :placeholder="datosCompletos"
                    v-model="datosCompletos"
                    id="datos"
                    name="datos"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    readonly
                    autoResize
                    rows="5"
                    cols="30"
                  />
                </div>

                <!--BOTÓN ENVIAR -->
                <div class="flex justify-end">
                  <button
                    @click.prevent="($event) => ConfirmDialog()"
                    type="submit"
                    class="mb-2 md:mb-0 bg-green-400 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-green-500"
                    :disabled="formProcessing || !areCamposRequeridosLlenos()"
                    :class="{
                      'opacity-25':
                        formProcessing || !areCamposRequeridosLlenos(),
                    }"
                  >
                    OBTENER TICKET
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


