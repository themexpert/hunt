<template>
    <div class="widget widget-feature-filter">
        <h3 class="widget-title mt0">Feature Filter</h3>
        <div class="filter-btn">
            <router-link class="waves-effect waves-light btn" to="/reports">Any</router-link>
            <router-link class="waves-effect waves-light btn" to="/reports/filter/access/private">Private</router-link>
            <router-link class="waves-effect waves-light btn" to="/reports/filter/access/public">Public</router-link>
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
        }
    }
</script>
