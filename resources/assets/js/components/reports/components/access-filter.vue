<template>
    <div class="widget widget-feature-filter">
        <h3 class="widget-title mt0" v-text="lang.panel_title.feature_filter">Feature Filter</h3>
        <div class="filter-btn">
            <router-link class="waves-effect waves-light btn" :class="{active:filter==''}" to="/reports" v-text="lang.panel_text.filter.any">Any</router-link>
            <router-link class="waves-effect waves-light btn" :class="{active:filter=='private'}" to="/reports/filter/access/private" v-text="lang.panel_text.filter.private">Private</router-link>
            <router-link class="waves-effect waves-light btn" :class="{active:filter=='public'}" to="/reports/filter/access/public" v-text="lang.panel_text.filter.public">Public</router-link>
        </div>
    </div><!--/.widget-->
</template>
<style>
    
</style>
<script>
    export default{
        name: 'AccessFilter',
        data(){
            return{
            }
        },
        computed: {
            /**
             * Gets current filter
             *
             * @returns {*}
             */
            filter() {
                if(this.$route.params==null) return '';
                return this.$route.params.value || '';
            }
        }
    }
</script>
