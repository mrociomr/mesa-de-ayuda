import "./bootstrap";
import "../css/app.css";
//theme
import "primevue/resources/themes/lara-light-indigo/theme.css";
import "primeicons/primeicons.css";
import "vue-select/dist/vue-select.css";

import PrimeVue from "primevue/config";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import vSelect from "vue-select";

import DataTable from "primevue/datatable";
import AutoComplete from "primevue/autocomplete";
import VueSweetalert2 from "vue-sweetalert2";

import Dropdown from "primevue/dropdown";
import Column from "primevue/column";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import MultiSelect from "primevue/multiselect";
import Tag from "primevue/tag";
import TriStateCheckbox from "primevue/tristatecheckbox";
import Paginator from "primevue/paginator";
import Card from "primevue/card";
import FocusTrap from "primevue/focustrap";
import Toolbar from "primevue/toolbar";
import Textarea from "primevue/textarea";
import Dialog from "primevue/dialog";
import Image from "primevue/image";
import Chart from "primevue/chart";
import ScrollPanel from "primevue/scrollpanel";
import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';


const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return (
            createApp({ render: () => h(App, props) })
                .use(plugin)
                .use(PrimeVue)
                .use(ZiggyVue, Ziggy)
                .use(ToastService)

                .component("v-select", vSelect)
                //A
                .component("AutoComplete", AutoComplete)
                //B
                .component("Button", Button)
                //C
                .component("Column", Column)
                .component("Card", Card)
                .component("Chart", Chart)
                //D
                .component("DataTable", DataTable)
                .component("Dropdown", Dropdown)
                .component("Dialog", Dialog)
                //I
                .component("InputText", InputText)
                .component("Image", Image)
                //M
                .component("MultiSelect", MultiSelect)
                //P
                .component("Paginator", Paginator)
                 //S
                 .component("ScrollPanel", ScrollPanel)
                //T
                .component("Tag", Tag)
                .component("TriStateCheckbox", TriStateCheckbox)
                .component("Toolbar", Toolbar)
                .component("Textarea", Textarea)
                .component('Toast', Toast)
                //V
                .component("VueSweetalert2", VueSweetalert2)

                .directive("focustrap", FocusTrap)
                .mount(el)
        );
    },
    progress: {
        color: "#4B5563",
    },
});
