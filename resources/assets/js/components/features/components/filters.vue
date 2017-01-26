<template>
    <ul>
        <li v-for="(value, slug) in filters" :class="{active:filter==slug}"><router-link :to="makeUrl(slug)">{{ value }}</router-link></li>
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
                filters: {
                    all: 'All',
                    awaiting_feedback: 'Awaiting Feedback',
                    in_progress: 'In Progress',
                    completed: 'Complete / Resolved'
                }
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
        watch: {
            filter() {
                this.$store.dispatch('apply_filter', this.filter);
            }
        }
    }
</script>
