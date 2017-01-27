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
<script type="text/babel">
    export default{
        props: ['filter'],
        data(){
            return{
            }
        },
        mounted() {
            Bus.$on('loaded', this.load);
        },
        methods: {
            load() {
                this.$store.dispatch('apply_filter', this.filter);
            },
            /**
             * Creates url for filter
             *
             * @param slug
             * @returns {string}
             */
            makeUrl(slug) {
                return '/products/' + this.product_id + '/features/' + slug;
            }
        },
        computed: {
            /**
             * Retrieves current product ID
             *
             * @returns {computed.product_id|*|null}
             */
            product_id() {
                return this.$store.state.features.product_id;
            },

            /**
             * Retrieves filters list from store
             *
             * @returns {Array}
             */
            filters() {
                return this.$store.state.features.statuses;
            }
        },
        watch: {
            /**
             * Watches for filter change
             */
            filter() {
                this.$store.dispatch('apply_filter', this.filter);
            }
        }
    }
</script>
