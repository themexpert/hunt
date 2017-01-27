<template>
    <ul>
        <li v-for="filterItem in filters" :class="{active:filter==filterItem.slug}"><router-link :to="makeUrl(filterItem.slug)">{{ filterItem.label }}</router-link></li>
    </ul>
</template>
<style>
    a:hover {
        cursor: pointer;
    }
</style>
<script>
    export default{
        props: ['filter'],
        data(){
            return{
            }
        },
        mounted() {
            this.$store.dispatch('apply_filter', this.filter);
        },
        methods: {
            makeUrl(slug) {
                return '/features/' + slug;
            }
        },
        computed: {
            filters() {
                return this.$store.state.features.statuses;
            }
        },
        watch: {
            filter() {
                this.$store.dispatch('apply_filter', this.filter);
            }
        }
    }
</script>
