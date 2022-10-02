<template>
    <div>
        <button class="btn btn-success" v-on:click="verMetricas()">Ver Métricas</button><br><br>

        <div v-if="metricasFlag">
            <div class="row justify-content-md-center">
                <!--<div class="col-6">
                    <Bar v-if="loaded" :chart-data="chartData"/>
                </div>-->
                <div class="col-md-5">
                    <Doughnut v-if="loaded" :chart-data="chartData"/>
                </div>
            </div><br><br>
        </div>
    </div>
</template>

<script>

    import { Bar } from 'vue-chartjs'
    import { Doughnut } from 'vue-chartjs'
    import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, ArcElement, CategoryScale, LinearScale } from 'chart.js'

    ChartJS.register(Title, Tooltip, Legend, BarElement, ArcElement, CategoryScale, LinearScale)

    export default {

        components: { Bar, Doughnut },

        props: {

            idUser: Number

        },

        data(){
            return{

                metricasFlag: false,
                loaded: false,
                chartData: null
            }
        },

        async mounted() {

            this.loaded = false
            await axios.get('/api/userMetrics/' + this.idUser)
                .then(response=>{

                    this.chartData = response.data
                    //console.log(this.idUser)
                    this.loaded = true
                })
                .catch(error=>{
                    alert(error);
                    console.log(error)
                })
        },

        methods:{

            verMetricas(){

                if(!this.metricasFlag){

                    this.metricasFlag = true;
                } else {

                    this.metricasFlag = false;
                }  
            }
        }
    }
</script>