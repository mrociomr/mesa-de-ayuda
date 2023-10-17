<script setup>
import { ref, onMounted, computed } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import SiderbarLink from "@/Components/SiderbarLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/inertia-vue3";
import axios from "axios";

const showingNavigationDropdown = ref(false);
const abrirOpUsua = ref(false);
</script>

<template>
  <div>
    <nav class="bg-white border-b border-gray-200 fixed z-30 w-full">
      <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
          <div class="flex items-center justify-start">
            <button
              class="lg:hidden mr-2 text-gray-600 hover:text-gray-900 cursor-pointer p-2 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100 rounded"
              @click="showingNavigationDropdown = !showingNavigationDropdown"
            >
              <svg
                id="toggleSidebarMobileHamburger"
                class="w-6 h-6"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                  clip-rule="evenodd"
                ></path>
              </svg>
              <svg
                id="toggleSidebarMobileClose"
                class="w-6 h-6 hidden"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </button>
            <a
              :href="route('dashboard')"
              class="text-xl font-bold flex items-center lg:ml-2.5"
            >
              <img
                src="/images/Escudo_de_Puno.png"
                class="h-10 mr-4"
                alt="Escudo de Puno"
                width="35"
                height="35"
              />
              <span class="self-center whitespace-nowrap">Mesa de Ayuda</span>
            </a>
            <form action="#" method="GET" class="hidden lg:block lg:pl-32">
              <label for="topbar-search" class="sr-only">Buscar</label>
              <div class="mt-1 relative lg:w-64">
                <div
                  class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                >
                  <svg
                    class="w-5 h-5 text-gray-500"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>

                <input
                  type="text"
                  name="search"
                  id="topbar-search"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full pl-10 p-2.5"
                  placeholder="Buscar"
                />
              </div>
            </form>
          </div>
          <div class="flex items-center ml-3">
            <div>
              <button
                type="button"
                @click="abrirOpUsua = !abrirOpUsua"
                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                aria-expanded="false"
                data-dropdown-toggle="dropdown-user"
              >
                <span class="sr-only">Open user menu</span>
                <!-- <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo"> -->
                <span class="text-bg-gray-600 mx-2">{{
                  $page.props.auth.user.name
                }}</span>

                <svg
                  class="ml-2 -mr-0.5 h-4 w-4"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path
                    fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"
                  />
                </svg>
              </button>
            </div>
            <div
              class="z-50 absolute top-10 right-5 my-4 text-base list-none divide-y rounded shadow-lg bg-white divide-gray-200"
              :class="{ block: abrirOpUsua, hidden: !abrirOpUsua }"
              id="dropdown-user"
            >
              <div class="px-4 py-3" role="none">
                <p class="text-sm text-gray-900 text-center" role="none">
                  Rol : {{ $page.props.auth.roles }}
                </p>
                <p class="text-sm text-gray-900 text-center" role="none">
                  {{ $page.props.auth.user.name }}
                </p>
                <p
                  class="text-sm font-medium truncate text-gray-900"
                  role="none"
                >
                  {{ $page.props.auth.user.email }}
                </p>
              </div>
              <ul class="py-1" role="none">
                <li>
                  <Link
                    :href="route('profile.edit')"
                    class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem"
                  >
                    Cambiar contraseña
                  </Link>
                </li>
                <li>
                  <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem"
                    >Cerrar Sesión</Link
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <div class="bg-gray-100 min-h-screen">
      <div class="flex overflow-hidden pt-16">
        <aside
          :class="{
            'w-100': showingNavigationDropdown,
            'ml-[-100%]': !showingNavigationDropdown,
          }"
          class="fixed lg:ml-0 md:w-4/12 lg:w-[25%] xl:w-[20%] 2xl:w-[15%] z-20 h-full top-0 left-0 pt-16 flex lg:flex flex-shrink-0 flex-col w-64 transition-width duration-75"
        >
          <div
            class="relative flex-1 flex flex-col min-h-0 border-r border-gray-200 bg-white pt-0"
          >
            <div class="flex-1 flex flex-col pt-5 pb-4">
              <div class="flex-1 px-3 divide-y space-y-1">
                <ul class="space-y-2 pb-2">
                  <!-- <li>
                    <form action="#" method="GET" class="lg:hidden">
                      <label for="mobile-search" class="sr-only">Search</label>
                      <div class="relative">
                        <div
                          class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                        >
                          <svg
                            class="w-5 h-5 text-gray-500"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                              d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                            ></path>
                          </svg>
                        </div>
                        <input
                          type="text"
                          name="email"
                          id="mobile-search"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 block w-full pl-10 p-2.5"
                          placeholder="Search"
                        />
                      </div>
                    </form>
                  </li> -->
                  <li>
                    <SiderbarLink
                      :href="route('dashboard')"
                      :active="route().current('dashboard')"
                      class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="w-6 h-6"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"
                          clip-rule="evenodd"
                        />
                        <path
                          fill-rule="evenodd"
                          d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"
                          clip-rule="evenodd"
                        />
                      </svg>

                      <span class="ml-3">Dashboard</span>
                    </SiderbarLink>
                  </li>

                  <!-- <div v-for="permission in $page.props.auth.permissions" :key="permission.id">
  <div v-if="permission.name === 'dependencia.index'"> -->
                  <li
                    v-if="
                      $page.props.auth.permissions.some(
                        (permission) => permission.name === 'dependencia.index'
                      )
                    "
                  >
                    <SiderbarLink
                      :href="route('dependencia.index')"
                      :active="route().current('dependencia.*')"
                      target="_blank"
                      class="text-base text-gray-900 font-normal rounded-lg hover-bg-gray-100 flex items-center p-2 group"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="w-6 h-6"
                      >
                        <path
                          d="M5.566 4.657A4.505 4.505 0 016.75 4.5h10.5c.41 0 .806.055 1.183.157A3 3 0 0015.75 3h-7.5a3 3 0 00-2.684 1.657zM2.25 12a3 3 0 013-3h13.5a3 3 0 013 3v6a3 3 0 01-3 3H5.25a3 3 0 01-3-3v-6zM5.25 7.5c-.41 0-.806.055-1.184.157A3 3 0 016.75 6h10.5a3 3 0 012.683 1.657A4.505 4.505 0 0018.75 7.5H5.25z"
                        />
                      </svg>
                      <span class="ml-3 flex-1 whitespace-nowrap"
                        >Dependencias</span
                      >
                    </SiderbarLink>
                  </li>
                  <!-- </div>
</div> -->
                  <li
                  v-if="
                      $page.props.auth.permissions.some(
                        (permission) => permission.name === 'incidencia.index'
                      )
                    "
                  >
                    <SiderbarLink
                      :href="route('incidencia.index')"
                      :active="route().current('incidencia.*')"
                      target="_blank"
                      class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="w-6 h-6"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M12 6.75a5.25 5.25 0 016.775-5.025.75.75 0 01.313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 011.248.313 5.25 5.25 0 01-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 112.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0112 6.75zM4.117 19.125a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75h-.008a.75.75 0 01-.75-.75v-.008z"
                          clip-rule="evenodd"
                        />
                        <path
                          d="M10.076 8.64l-2.201-2.2V4.874a.75.75 0 00-.364-.643l-3.75-2.25a.75.75 0 00-.916.113l-.75.75a.75.75 0 00-.113.916l2.25 3.75a.75.75 0 00.643.364h1.564l2.062 2.062 1.575-1.297z"
                        />
                        <path
                          fill-rule="evenodd"
                          d="M12.556 17.329l4.183 4.182a3.375 3.375 0 004.773-4.773l-3.306-3.305a6.803 6.803 0 01-1.53.043c-.394-.034-.682-.006-.867.042a.589.589 0 00-.167.063l-3.086 3.748zm3.414-1.36a.75.75 0 011.06 0l1.875 1.876a.75.75 0 11-1.06 1.06L15.97 17.03a.75.75 0 010-1.06z"
                          clip-rule="evenodd"
                        />
                      </svg>

                      <span class="ml-3 flex-1 whitespace-nowrap"
                        >Incidencias Pendientes</span
                      >
                    </SiderbarLink>
                  </li>

                  <li
                  v-if="
                      $page.props.auth.permissions.some(
                        (permission) => permission.name === 'solucion.index'
                      )
                    "
                  >
                    <SiderbarLink
                      :href="route('solucion.index')"
                      :active="route().current('solucion.*')"
                      target="_blank"
                      class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13"
                        />
                      </svg>

                      <span class="ml-3 flex-1 whitespace-nowrap"
                        >Incidencias Atendidas</span
                      >
                    </SiderbarLink>
                  </li>

                  <li
                  v-if="
                      $page.props.auth.permissions.some(
                        (permission) => permission.name === 'tipo-solucion.index'
                      )
                    "
                  >
                    <SiderbarLink
                      :href="route('tipo-solucion.index')"
                      :active="route().current('tipo-solucion.*')"
                      target="_blank"
                      class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="w-6 h-6"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M1.5 7.125c0-1.036.84-1.875 1.875-1.875h6c1.036 0 1.875.84 1.875 1.875v3.75c0 1.036-.84 1.875-1.875 1.875h-6A1.875 1.875 0 011.5 10.875v-3.75zm12 1.5c0-1.036.84-1.875 1.875-1.875h5.25c1.035 0 1.875.84 1.875 1.875v8.25c0 1.035-.84 1.875-1.875 1.875h-5.25a1.875 1.875 0 01-1.875-1.875v-8.25zM3 16.125c0-1.036.84-1.875 1.875-1.875h5.25c1.036 0 1.875.84 1.875 1.875v2.25c0 1.035-.84 1.875-1.875 1.875h-5.25A1.875 1.875 0 013 18.375v-2.25z"
                          clip-rule="evenodd"
                        />
                      </svg>

                      <span class="ml-3 flex-1 whitespace-nowrap"
                        >Tipos de solución</span
                      >
                    </SiderbarLink>
                  </li>

                  <li
                  v-if="
                      $page.props.auth.permissions.some(
                        (permission) => permission.name === 'tipo-problema.index'
                      )
                    "
                  >
                    <SiderbarLink
                      :href="route('tipo-problema.index')"
                      :active="route().current('tipo-problema.*')"
                      target="_blank"
                      class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="w-6 h-6"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                          clip-rule="evenodd"
                        />
                      </svg>

                      <span class="ml-3 flex-1 whitespace-nowrap"
                        >Tipos de problemas</span
                      >
                    </SiderbarLink>
                  </li>
                  <li
                  v-if="
                      $page.props.auth.permissions.some(
                        (permission) => permission.name === 'sede.index'
                      )
                    "
                  >
                    <SiderbarLink
                      :href="route('sede.index')"
                      :active="route().current('sede.*')"
                      target="_blank"
                      class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="w-6 h-6"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M3 2.25a.75.75 0 000 1.5v16.5h-.75a.75.75 0 000 1.5H15v-18a.75.75 0 000-1.5H3zM6.75 19.5v-2.25a.75.75 0 01.75-.75h3a.75.75 0 01.75.75v2.25a.75.75 0 01-.75.75h-3a.75.75 0 01-.75-.75zM6 6.75A.75.75 0 016.75 6h.75a.75.75 0 010 1.5h-.75A.75.75 0 016 6.75zM6.75 9a.75.75 0 000 1.5h.75a.75.75 0 000-1.5h-.75zM6 12.75a.75.75 0 01.75-.75h.75a.75.75 0 010 1.5h-.75a.75.75 0 01-.75-.75zM10.5 6a.75.75 0 000 1.5h.75a.75.75 0 000-1.5h-.75zm-.75 3.75A.75.75 0 0110.5 9h.75a.75.75 0 010 1.5h-.75a.75.75 0 01-.75-.75zM10.5 12a.75.75 0 000 1.5h.75a.75.75 0 000-1.5h-.75zM16.5 6.75v15h5.25a.75.75 0 000-1.5H21v-12a.75.75 0 000-1.5h-4.5zm1.5 4.5a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75h-.008a.75.75 0 01-.75-.75v-.008zm.75 2.25a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75v-.008a.75.75 0 00-.75-.75h-.008zM18 17.25a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75h-.008a.75.75 0 01-.75-.75v-.008z"
                          clip-rule="evenodd"
                        />
                      </svg>

                      <span class="ml-3 flex-1 whitespace-nowrap">Sedes</span>
                    </SiderbarLink>
                  </li>
                  <li
                  v-if="
                      $page.props.auth.permissions.some(
                        (permission) => permission.name === 'oficina.index'
                      )
                    "
                  >
                    <SiderbarLink
                      :href="route('oficina.index')"
                      :active="route().current('oficina.*')"
                      target="_blank"
                      class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group"
                    >
                      <!--<svg
                      class="w-6 h-6 text-gray-900 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                      ></path>
                    </svg>-->
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="w-6 h-6"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M4.5 2.25a.75.75 0 000 1.5v16.5h-.75a.75.75 0 000 1.5h16.5a.75.75 0 000-1.5h-.75V3.75a.75.75 0 000-1.5h-15zM9 6a.75.75 0 000 1.5h1.5a.75.75 0 000-1.5H9zm-.75 3.75A.75.75 0 019 9h1.5a.75.75 0 010 1.5H9a.75.75 0 01-.75-.75zM9 12a.75.75 0 000 1.5h1.5a.75.75 0 000-1.5H9zm3.75-5.25A.75.75 0 0113.5 6H15a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75zM13.5 9a.75.75 0 000 1.5H15A.75.75 0 0015 9h-1.5zm-.75 3.75a.75.75 0 01.75-.75H15a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75zM9 19.5v-2.25a.75.75 0 01.75-.75h4.5a.75.75 0 01.75.75v2.25a.75.75 0 01-.75.75h-4.5A.75.75 0 019 19.5z"
                          clip-rule="evenodd"
                        />
                      </svg>

                      <span class="ml-3 flex-1 whitespace-nowrap"
                        >Oficinas</span
                      >
                    </SiderbarLink>
                  </li>
                  <li
                  v-if="
                      $page.props.auth.permissions.some(
                        (permission) => permission.name === 'user.index'
                      )
                    "
                  >
                    <SiderbarLink
                      :href="route('users.index')"
                      :active="route().current('users.*')"
                      target="_blank"
                      class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="w-6 h-6"
                      >
                        <path
                          d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.128l-.001.144a2.25 2.25 0 01-.233.96 10.088 10.088 0 005.06-1.01.75.75 0 00.42-.643 4.875 4.875 0 00-6.957-4.611 8.586 8.586 0 011.71 5.157v.003z"
                        />
                      </svg>

                      <span class="ml-3 flex-1 whitespace-nowrap"
                        >Usuarios</span
                      >
                    </SiderbarLink>
                  </li>
                  <li
                  v-if="
                      $page.props.auth.permissions.some(
                        (permission) => permission.name === 'reporte.index'
                      )
                    "
                  >
                    <SiderbarLink
                      :href="route('reporte.index')"
                      :active="route().current('reporte.*')"
                      target="_blank"
                      class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"
                        />
                      </svg>

                      <span class="ml-3 flex-1 whitespace-nowrap"
                        >Reportes</span
                      >
                    </SiderbarLink>
                  </li>

                  <li
                  v-if="
                      $page.props.auth.permissions.some(
                        (permission) => permission.name === 'token-mensaje.index'
                      )
                    "
                  >
                    <SiderbarLink
                      :href="route('token-mensaje.index')"
                      :active="route().current('token-mensaje.*')"
                      target="_blank"
                      class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                      <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h2.25a3 3 0 013 3v2.25a3 3 0 01-3 3H6a3 3 0 01-3-3V6zm9.75 0a3 3 0 013-3H18a3 3 0 013 3v2.25a3 3 0 01-3 3h-2.25a3 3 0 01-3-3V6zM3 15.75a3 3 0 013-3h2.25a3 3 0 013 3V18a3 3 0 01-3 3H6a3 3 0 01-3-3v-2.25zm9.75 0a3 3 0 013-3H18a3 3 0 013 3V18a3 3 0 01-3 3h-2.25a3 3 0 01-3-3v-2.25z" clip-rule="evenodd" />
                    </svg>
                    

                      <span class="ml-3 flex-1 whitespace-nowrap"
                        >TokenMensaje</span
                      >
                    </SiderbarLink>
                  </li>
                  <li
                  v-if="
                      $page.props.auth.permissions.some(
                        (permission) => permission.name === 'key-mensaje.index'
                      )
                    "
                  >
                    <SiderbarLink
                      :href="route('key-mensaje.index')"
                      :active="route().current('key-mensaje.*')"
                      target="_blank"
                      class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                      <path fill-rule="evenodd" d="M15.75 1.5a6.75 6.75 0 00-6.651 7.906c.067.39-.032.717-.221.906l-6.5 6.499a3 3 0 00-.878 2.121v2.818c0 .414.336.75.75.75H6a.75.75 0 00.75-.75v-1.5h1.5A.75.75 0 009 19.5V18h1.5a.75.75 0 00.53-.22l2.658-2.658c.19-.189.517-.288.906-.22A6.75 6.75 0 1015.75 1.5zm0 3a.75.75 0 000 1.5A2.25 2.25 0 0118 8.25a.75.75 0 001.5 0 3.75 3.75 0 00-3.75-3.75z" clip-rule="evenodd" />
                    </svg>
                    

                      <span class="ml-3 flex-1 whitespace-nowrap"
                        >KeyMensaje</span
                      >
                    </SiderbarLink>
                  </li>
                  <!-- <li>
                    <a
                      href="#"
                      target="_blank"
                      class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group"
                    >
                      <svg
                        class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z"
                        ></path>
                        <path
                          d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"
                        ></path>
                      </svg>
                      <span class="ml-3 flex-1 whitespace-nowrap">Inbox</span>
                      <span
                        class="bg-gray-200 text-gray-800 ml-3 text-sm font-medium inline-flex items-center justify-center px-2 rounded-full"
                        >Pro</span
                      >
                    </a>
                  </li> -->
                  <!-- <li>
                    <a
                      href="#"
                      class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group"
                    >
                      <svg
                        class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                          clip-rule="evenodd"
                        ></path>
                      </svg>
                      <span class="ml-3 flex-1 whitespace-nowrap">Users</span>
                    </a>
                  </li> -->
                  <!-- <li>
                    <a
                      href="#"
                      class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group"
                    >
                      <svg
                        class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                          clip-rule="evenodd"
                        ></path>
                      </svg>
                      <span class="ml-3 flex-1 whitespace-nowrap">Products</span>
                    </a>
                  </li> -->
                  <!-- <li>
                    <a
                      href="#"
                      class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group"
                    >
                      <svg
                        class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                          clip-rule="evenodd"
                        ></path>
                      </svg>
                      <span class="ml-3 flex-1 whitespace-nowrap">Sign In</span>
                    </a>
                  </li> -->
                  <!-- <li>
                    <a
                      href="#"
                      class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group"
                    >
                      <svg
                        class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z"
                          clip-rule="evenodd"
                        ></path>
                      </svg>
                      <span class="ml-3 flex-1 whitespace-nowrap">Sign Up</span>
                    </a>
                  </li> -->
                </ul>
                <!-- <div class="space-y-2 pt-2">
                  <a
                    href="#"
                    class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 group transition duration-75 flex items-center p-2"
                  >
                    <svg
                      class="w-5 h-5 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                      aria-hidden="true"
                      focusable="false"
                      data-prefix="fas"
                      data-icon="gem"
                      role="img"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 512 512"
                    >
                      <path
                        fill="currentColor"
                        d="M378.7 32H133.3L256 182.7L378.7 32zM512 192l-107.4-141.3L289.6 192H512zM107.4 50.67L0 192h222.4L107.4 50.67zM244.3 474.9C247.3 478.2 251.6 480 256 480s8.653-1.828 11.67-5.062L510.6 224H1.365L244.3 474.9z"
                      ></path>
                    </svg>
                    <span class="ml-4">Upgrade to Pro</span>
                  </a>
                  <a
                    href="#"
                    target="_blank"
                    class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 group transition duration-75 flex items-center p-2"
                  >
                    <svg
                      class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                      <path
                        fill-rule="evenodd"
                        d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                        clip-rule="evenodd"
                      ></path>
                    </svg>
                    <span class="ml-3">Documentation</span>
                  </a>
                  <a
                    href="#"
                    target="_blank"
                    class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 group transition duration-75 flex items-center p-2"
                  >
                    <svg
                      class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"
                      ></path>
                    </svg>
                    <span class="ml-3">Components</span>
                  </a>
                  <a
                    href="#"
                    target="_blank"
                    class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 group transition duration-75 flex items-center p-2"
                  >
                    <svg
                      class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-2 0c0 .993-.241 1.929-.668 2.754l-1.524-1.525a3.997 3.997 0 00.078-2.183l1.562-1.562C15.802 8.249 16 9.1 16 10zm-5.165 3.913l1.58 1.58A5.98 5.98 0 0110 16a5.976 5.976 0 01-2.516-.552l1.562-1.562a4.006 4.006 0 001.789.027zm-4.677-2.796a4.002 4.002 0 01-.041-2.08l-.08.08-1.53-1.533A5.98 5.98 0 004 10c0 .954.223 1.856.619 2.657l1.54-1.54zm1.088-6.45A5.974 5.974 0 0110 4c.954 0 1.856.223 2.657.619l-1.54 1.54a4.002 4.002 0 00-2.346.033L7.246 4.668zM12 10a2 2 0 11-4 0 2 2 0 014 0z"
                        clip-rule="evenodd"
                      ></path>
                    </svg>
                    <span class="ml-3">Help</span>
                  </a>
                </div> -->
              </div>
            </div>
          </div>
        </aside>

        <div class="lg:ml-56 h-full w-full">
          <main>
            <div class="pt-4 px-20 mb-6">
              <slot />
            </div>
          </main>
        </div>
      </div>
    </div>
  </div>
</template>
