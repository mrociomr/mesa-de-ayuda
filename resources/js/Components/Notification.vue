<template>
<transition name="slide-fade ">
<div class="m-auto" v-if="message && showNotification">
<div class="flex items-center w-full max-w-sm p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
<div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
</svg>
<span class="sr-only">Check icon</span>
</div>
<div class="ml-2 mr-6">
<span class="font-semibold">¡Completado exitosamente!</span>
<div class="ml-3 text-sm font-normal">{{message}}</div>
</div>
<button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-success" aria-label="Close">
<span class="sr-only">Close</span>
<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
</svg>
</button>
</div>
</div>
</transition>
</template>
<script setup >
import { defineProps, ref, onMounted } from 'vue';

const props = defineProps({
message: String
})

const showNotification = ref(false)

onMounted(() => {
showNotification.value = true;
setTimeout(() => (showNotification.value = false), 2000); 
})
</script>

<style>
.slide-fade-enter-active {
transition: all .3s ease;
}
.slide-fade-leave-active {
transition: all .4s cubic-bezier(1.0, 0.5, 0.8, 1.0); 
}

.slide-fade-enter, .slide-fade-leave-to {
transform: translateX(150px);
opacity: 0;
} 

</style>