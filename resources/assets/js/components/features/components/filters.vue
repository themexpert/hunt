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
            /**
             * Apply filter on initiation
             */
            this.$store.dispatch('apply_filter', this.filter);
        },
        methods: {
            /**
             * Creates url for filter
             *
             * @param slug
             * @returns {string}
             */
            makeUrl(slug) {
                if(this.product_id==null) return '';
                if(slug=='') return '/products/'+this.product_id+'/features';
                return '/products/' + this.product_id + '/features/filter/' + slug;
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
