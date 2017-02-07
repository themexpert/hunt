<template>
    <div id="effort-vs-value" style="width: 600px; height: 500px;" class="col s9"></div>
</template>
<style>
    
</style>
<script>
    import Hunt from '../../../config/Hunt'
    import preloader_2 from '../../helpers/preloader-2.vue'
    export default{
        name: 'EffortVSPriorityGraph',
        components: {
            'preloader-2': preloader_2
        },
        data(){
            return{
            }
        },
        mounted() {
            Hunt.renderPage("Graph Report");
            this.$store.dispatch('reloadFeatures', {
                type: this.filter_type,
                value: this.filter_value
            });
            Bus.$on('google-chart-loaded', ()=>this.renderChart());
        },
        methods: {
            checkForChartLoaded() {
                if(typeof window.google=='undefined') {
                    let script = document.createElement('script');
                    script.setAttribute('src','https://www.gstatic.com/charts/loader.js');
                    document.body.appendChild(script);
                    let script2 = document.createElement('script');
                    script2.innerHTML = "google.charts.load('current', {'packages':['corechart']});" +
                        "\ngoogle.charts.setOnLoadCallback(()=>{Bus.$emit('google-chart-loaded');});";
                    script.onload = ()=> document.body.appendChild(script2);
                    return false;
                }
                return true;
            },
            prepareChartData() {
                //data
                let effortAndPriorityData = [['Name', 'Effort', 'Priority', 'Ratio']];
                this.features.forEach(x=>{
                    effortAndPriorityData.push([x.name, x.effort_value, x.priority_value, x.effort_value/x.priority_value]);
                });
                let data = google.visualization.arrayToDataTable(effortAndPriorityData);

                //options
                let options = {
                    title: 'Effort VS Priority/Value Chart',
                    hAxis: {title: 'Effort'},
                    vAxis: {title: 'Priority'},
                    bubble: {textStyle: {fontSize: 11}}
                };

                return {
                    data: data,
                    options: options
                }
            },
            renderChart() {
                let data = this.prepareChartData();
                let chart = new google.visualization.BubbleChart(document.getElementById('effort-vs-value'));
                chart.draw(data.data, data.options);
            }
        },
        computed: {
            features() {
                return this.$store.state.reports.features;
            },

            /**
             * Gets filter type from route
             */
            filter_type() {
                return this.$route.params.type;
            },
            /**
             * Gets filter value from route
             */
            filter_value() {
                return this.$route.params.value;
            }
        },
        watch: {
            features() {
                if(this.checkForChartLoaded()) this.renderChart();
            }
        }
    }
</script>
