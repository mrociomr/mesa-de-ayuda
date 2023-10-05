<template>
  <AuthenticatedLayout>
    <div class="flex justify-content-center p-fluid">
      <div v-focustrap class="card">
        <h2>{{ editing ? "Editar" : "Crear" }} Dependencia</h2>

        <div>
          <label for="nombre">Dni:</label>
          <input v-model="form.dni" type="text" id="dni" name="dni" />
          <span v-if="errors.dni" class="text-red-500">{{
            errors.dni[0]
          }}</span>
        </div>

        <div>
          <label for="nombre">Celular:</label>
          <input
            v-model="form.celular"
            type="text"
            id="celular"
            name="celular"
          />
          <span v-if="errors.celular" class="text-red-500">{{
            errors.celular[0]
          }}</span>
        </div>
        <div>
          <label>Oficina:</label>
          <select v-model="form.oficina_id">
            <option
              v-for="oficina in oficinas"
              :key="oficina.id"
              :value="oficina.id"
            >
              {{ oficina.abreviatura }}
            </option>
          </select>
        </div>
      <!-- <div>
          <label>Tipo de Problema:</label>
          <select v-model="form.tipo_problema_id">
            <option
              v-for="tipoProblema in tiposProblema"
              :key="tipoProblema.id"
              :value="tipoProblema.id"
            >
              {{ tipoProblema.nombre }}
            </option>
          </select>
        </div>-->
        <div class="card flex justify-content-center">
          <AutoComplete
            v-model="form.tipo_problema_id"
            :suggestions="tiposProblemas"
            @complete="search"
            dropdown
          />
        </div>

        <div>
          <button @click="handleSubmit">
            {{ editing ? "Actualizar" : "Guardar" }}
          </button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

    <script setup>
import { ref, onMounted, defineProps } from "vue";
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
  oficinas: Array,
  tiposProblema: Array,
  editing: Boolean,
  dependenciaId: Number,
});

const form = ref({
  dni: "",
  celular: "",
  tipo_problema_id: "",
  oficina_id: "",
});
console.log(form);
const errors = ref({});

const oficinas = ref([]);
const tiposProblema = ref([]);
console.log(oficinas);

onMounted(() => {
  console.log("Props oficinas:", props.oficinas);
  console.log("Props tiposProblema:", props.tiposProblema);
  oficinas.value = props.oficinas;
  tiposProblema.value = props.tiposProblema;
});

const tiposProblemas = ref([]);

/*const search = (event) => {
  tiposProblemas.value = tiposProblema.value.map((tipoProblema) => (tipoProblema.nombre ));
  //items.value = event.query ? [...Array(10).keys()].map((item) => event.query + '-' + item) : _items;
};*/

const search = (event) => {
  const query = event.query.toLowerCase();

  const tiposProblemasNombres = tiposProblema.value.map((tipoProblema) =>
    tipoProblema.nombre.toLowerCase()
  );

  const tiposProblemasFiltrados = tiposProblemasNombres.filter((nombre) =>
    nombre.includes(query)
  );
  tiposProblemas.value = tiposProblemasFiltrados;
};



const filteredTiposProblema = ref([]);

async function handleSubmit() {
  const url = props.editing ? `/incidencias/${props.id}/edit` : "/incidencia";
  const method = props.editing ? "put" : "post";

  const response = await Inertia[method](url, form.value);
  console.log(response);

  if (response.ok) {
    this.$inertia.visit("/incidencia");
  } else {
    errors.value = response.errors || {};
  }
}
</script>
