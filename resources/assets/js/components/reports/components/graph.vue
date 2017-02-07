<template>
    <div class="col s9">
        <div class="row range-field">
            <input type="range" v-model="effort" :min="minEffort" :max="maxEffort" @change="renderChart" class="col s9">
            <span class="col s3">Minimum Effort: {{ effort }}</span>
        </div>
        <div id="effort-vs-value" style="width: 600px; height: 500px;" class="col s12"></div>
    </div>
</template>
<style>
    
</style>
<script>
    import Hunt from '../../../config/Hunt'
    export default{
        name: 'EffortVSPriorityGraph',
        data(){
            return{
                chart: null,
                effort: 0
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
                let effortAndPriorityData = [['Name', 'Effort', 'Priority', 'Product', 'Value']];
                this.features.forEach(x=>{
                    if(this.effort<=x.effort_value) effortAndPriorityData.push([x.feature_name, x.effort_value, x.priority_value, x.product_name, (x.effort_value+x.priority_value)/2]);
                });
                let data = google.visualization.arrayToDataTable(effortAndPriorityData);

                //options
                let options = {
                    title: 'Effort VS Priority Chart',
                    hAxis: {title: 'Effort'},
                    vAxis: {title: 'Priority'},
                    bubble: {textStyle: {fontSize: 11}},
                    animation: {duration: 400, easing: 'out'}
                };

                return {
                    data: data,
                    options: options
                }
            },
            renderChart() {
                if(this.effort<this.minEffort) this.effort=this.minEffort;
                let data = this.prepareChartData();
                if(this.chart==null) this.chart = new google.visualization.BubbleChart(document.getElementById('effort-vs-value'));
                this.chart.draw(data.data, data.options);
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
            },
            minEffort() {
                let min = null;
                this.features.forEach(x=>{
                    if(min==null)
                        min=x.effort_value;
                    else
                        if(min>x.effort_value)
                            min=x.effort_value;
                });
                return min!=null?min:0;
            },
            maxEffort() {
                let min = null;
                this.features.forEach(x=>{
                    if(min==null)
                        min=x.effort_value;
                    else
                    if(min<x.effort_value)
                        min=x.effort_value;
                });
                return min!=null?min:0;
            }
        },
        watch: {
            features() {
                if(this.checkForChartLoaded()) this.renderChart();
            }
        }
    }
</script>
