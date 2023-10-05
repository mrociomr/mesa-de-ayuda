<template>
    <Head title="Usuarios" />
    <AuthenticatedLayout>
        <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8  2xl:col-span-2 text-sm">
  
            <div class="grid grid-rows-1 grid-flow-col">
              <div class="flex justify-start">
                <span class="p-input-icon-left">
                  <i class="pi pi-search" />
                  <InputText
                    v-model="nombreFilter"
                    @input="applyFilter"
                    placeholder="Buscar..."
                  />
                </span>
              </div>
              <div class="flex justify-end md:object-right">
              
               <!--  <PrimaryButton
                  @click="$event => openModal(1)">
                  Add
                </PrimaryButton>
              -->
              <Link :href="route('users.create')">
                <Button label="Crear"
                icon="pi pi-plus"
                raised />
              </Link>
              
              </div>
            </div>
          <div class="py-10">
            <DataTableComponent
          :data="User"
          :columns="tableColumns"
          :perPage="6"
          @delete="deleteRow"
          :showButtonDelete="showButton"
          @edit="editRow"
          :showButtonEdit="showButton"
          @view="showRow"
          :showButtonView="showButton"
        >
        </DataTableComponent>
  
    <!--    <Modal :show="modal" @close="closeModal">
          <h2 class="p-3 text-lg font.medium text-hray-900">{{title}}</h2>
        </Modal>
      -->
        <Dialog
        v-model:visible="visible"
        modal
        header="Detalles"
        :style="{ width: '50vw' }"
        :breakpoints="{ '960px': '75vw', '641px': '100vw' }"
      >
      
      <div class="flex justify-center items-center">
    </div>
        <div class="grid grid-cols-2 gap-2">
          <div class="mb-6">
            <label
              for="name"
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
              >Nombre</label
            >
            <input
              type="text"
              v-model="selectedRow.name"
              id="name"
              name="name"
              class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full p-2.5 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none cursor-not-allowed"
              disabled
            />
          </div>
          <div class="mb-6">
            <label
              for="email"
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
              >Email</label
            >
            <input
              type="text"
              v-model="selectedRow.email"
              id="email"
              name="email"
              class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full p-2.5 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none cursor-not-allowed"
              disabled
            />
          </div>
          <div class="mb-6">
            <label
              for="password"
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
              >Contraseña</label
            >
            <input
              type="text"
              v-model="selectedRow.password"
              id="password"
              name="password"
              class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full p-2.5 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none cursor-not-allowed"
              disabled
            />
          </div>
          <div class="mb-6">
            <label
              for="created_at"
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
              >Fecha de creación</label
              
              >
              <input
              type="text"
              v-model="selectedRow.created_at"
              id="created_at"
              name="created_at"
              class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full p-2.5 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none cursor-not-allowed"
              disabled
            />
          </div>
          <div class="mb-6">
            <label
              for="updated_at"
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 font-sans"
              >Fecha de actualización</label
            >
            <input
              type="datetime"
              v-model="selectedRow.updated_at"
              id="updated_at"
              name="updated_at"
              class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full p-2.5 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none cursor-not-allowed"
              disabled
            />
          </div>
        </div>
        
        
        <template #footer>
          <Button label="Cerrar" icon="pi pi-times" @click="visible = false" text />
        </template>
      </Dialog>
          </div>
  
      </div>
      </AuthenticatedLayout>
    </template>
  
  
      <script setup>
    import DataTableComponent from "@/Components/TablePrimeVue.vue";
    import { ref, computed } from "vue";
    import { Head, useForm, Link} from "@inertiajs/inertia-vue3";
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
    import Swal from 'sweetalert2';

    
  
     
    const form = useForm({});
    const props = defineProps(["user", "tableColumns"],
    );
    
    const id = ref('');
  
    const nombreFilter = ref("");
    const User = computed(() => {
      if (!nombreFilter.value) {
        return props.user;
      }
      const filter = nombreFilter.value.toLowerCase();
      return props.user.filter((item) =>
        item.name.toLowerCase().includes(filter)
       
  
      );
    });
  
    const applyFilter = () => {};
  
  
    const showButton = ref(true);
  
    const toggleButton = () => {
      showButton.value = !showButton.value;
    };
  
   

  
    const editRow = (rowData) => {
        //console.log("users.edit", rowData);
      form.get(route("users.edit",rowData))
    };
  
    const deleteRow = (rowId) => {
     /* console.log("Delete row with ID:", rowId);
      Swal.fire({
      title: '¿Estás seguro?',
      text: "¡No podrás revertir esta acción!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '¡Si, elimínalo!'
      }).then((result) => {
      if (result.isConfirmed) {
        form.delete(route("sede.destroy", rowId));
        Swal.fire(
          'Deleted!',
          'Your file has been deleted.',
          'success'
        )
    }
  }) */
      //console.log("Delete row with ID:", rowId);
      form.delete(route("users.destroy", rowId));
    };
  
  const visible = ref(false);
  
  const selectedRow = ref({
    id: "",
    name: "",
    email: "",
    password: "",
    created_at: "",
    updated_at: "",
  });
  //console.log(selectedRow);
  
  const showRow = (rowId) => {
    //console.log("Aceptar row with ID:", rowId);
    selectedRow.value.id = rowId.id;
    //console.log(selectedRow.value.id);
    selectedRow.value.name = rowId.name;
    selectedRow.value.email = rowId.email;
    selectedRow.value.password = rowId.password;
    selectedRow.value.created_at = rowId.created_at;
    selectedRow.value.updated_at = rowId.updated_at;
  
    visible.value = true;
  };
  
    </script>
  
  
  
  
  