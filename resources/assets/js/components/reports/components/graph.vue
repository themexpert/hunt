<template>
    <div class="col s9">
        <div class="row range-field">
            <div id="slider-range"></div>
        </div>
        <div id="effort-vs-value" style="width: 600px; height: 500px;" class="col s12"><spinner></spinner></div>
    </div>
</template>
<style>
    
</style>
<script type="text/babel">
    import Hunt from '../../../config/Hunt'
    import noUISlider from 'nouislider'
    export default{
        name: 'EffortVSPriorityGraph',
        data(){
            return{
                sliderElem: null,
                chart: null,
                min: 70,
                max: 100
            }
        },
        mounted() {
            this.sliderElem = document.getElementById('slider-range');
            noUISlider.create(this.sliderElem, {
                start: [70, 100],
                connect: true,
                range: {
                    'min': 0,
                    'max': 100
                }
            });
            this.sliderElem.noUiSlider.on('change', (values, handle)=>{
                if(values[0]!=this.min || values[1]!=this.max) {
                    this.min = Math.floor(values[0]);
                    this.max = Math.ceil(values[1]);
                    this.$store.dispatch('reloadReportsGraph', {
                        min: this.min,
                        max: this.max
                    });
                }
            });
            this.$store.dispatch('reloadReportsGraph', {
                min: this.min,
                max: this.max
            });
            Hunt.renderPage("Graph Report");
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
                if (this.features.length == 0)
                    effortAndPriorityData.push(['No Data Available', 0, 0, 'No Data Available', 0]);
                else
                    this.features.forEach(x => {
                        effortAndPriorityData.push([x.feature_name, x.effort_value, x.priority_value, x.product_name, (x.effort_value + x.priority_value) / 2]);
                    });
                let data = google.visualization.arrayToDataTable(effortAndPriorityData);

                //options
                let options = {
                    title: 'Effort VS Priority Chart (Min: '+this.min+", Max: "+this.max+')',
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
                return this.$store.state.reports.features.filter(x=>{
                        return x.product==undefined;
                    });
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
