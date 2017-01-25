<template>
    <ul>
        <li v-for="(value, key) in filters" :class="{active:filter==key}"><a @click="setFilter(key)" >{{ value }}</a></li>
    </ul>
</template>
<style>
    a:hover {
        cursor: pointer;
    }
</style>
<script>
    export default{
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
        methods: {
            setFilter(newFilter) {
                this.$store.dispatch('apply_filter', newFilter);
            }
        },
        computed: {
            filter() {
                return this.$store.state.features.filter;
            }
        }
    }
</script>
