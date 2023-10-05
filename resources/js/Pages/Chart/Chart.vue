    <template>
        <div class="card flex justify-content-center">
            <Chart type="pie" :data="chartData" :options="chartOptions" class="w-full md:w-30rem" />
        </div>
    </template>

    <script setup>
    import { ref, onMounted, computed } from "vue";

    import { Head, useForm, Link } from "@inertiajs/vue3";


    const form = useForm({});

    const props = defineProps(["GrafPendSolu"]);
    //console.log(props.GrafPendSolu);

    onMounted(() => {
        chartData.value = setChartData();
    });

    const chartData = ref();
    const chartOptions = ref({
        plugins: {
            legend: {
                labels: {
                    usePointStyle: true
                }
            }
        }
    });

    const setChartData = () => {
        const documentStyle = getComputedStyle(document.body);
        return {
            labels: ['Incidencias Pendientes', 'Soluciones Realizadas'],
            datasets: [
                {
                    data: [props.GrafPendSolu.incidencias_pendientes, props.GrafPendSolu.soluciones_realizadas],
                    backgroundColor: [documentStyle.getPropertyValue('--red-500'), documentStyle.getPropertyValue('--yellow-500'), documentStyle.getPropertyValue('--green-500')],
                    hoverBackgroundColor: [documentStyle.getPropertyValue('--red-500'), documentStyle.getPropertyValue('--yellow-400'), documentStyle.getPropertyValue('--green-400')]
                }
            ]
        };
    };
    </script>
