<template>
    <div class="widget widget-feature-tags mt30">
        <h3 class="widget-title">Feature Tags</h3>
        <div class="filter-btn">
            <router-link class="waves-effect waves-light btn" v-for="tag in tags" :to="getUrl(tag.value)">{{ tag.label }}</router-link>
        </div>
    </div><!--/.widget-->
</template>
<style>
    
</style>
<script>
    export default{
        name: 'TagsFilter',
        data(){
            return{
            }
        },
        methods: {
            getUrl(tagId) {
                return '/reports/filter/tags/'+tagId;
            }
        },
        computed: {
            tags() {
                return this.$store.state.features.tags;
            }
        }
    }
</script>
