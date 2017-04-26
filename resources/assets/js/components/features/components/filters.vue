<template>
    <ul>
        <li v-for="filterItem in filters" :class="{active:filter==filterItem.slug}">
            <router-link :to="makeUrl(filterItem.slug)">{{ filterItem.label }}</router-link>
        </li>
    </ul>
</template>
<style>
    a:hover {
        cursor: pointer;
    }
</style>
<script type="text/babel">
    export default{
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
                if(this.product_id==null) return '#';
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
                return this.$route.params.product_id;
            },

            /**
             * Retrieves filters list from store
             *
             * @returns {Array}
             */
            filters() {
                const statuses =  this.$store.state.features.statuses;
                statuses.map((status)=>{
                    status.label = this.lang.status[status.slug]!==undefined?this.lang.status[status.slug]:status.label;
                    return status;
                });
                return statuses;
            },

            /**
             * Returns current filter
             */
            filter() {
                return this.$route.params.filter || '';
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
