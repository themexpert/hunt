<template>
    <li class="collection-item avatar" :class="statusClass">
        <i class="material-icons circle">done</i>
        <h4 class="title"><router-link :to="productUrl">{{ feature.product.name }}</router-link>: <router-link :to="featureUrl">{{ feature.name }}</router-link></h4>
        <tag :tags="feature.tags"></tag>
        <div class="description">
            {{ feature.description }}
        </div>
        <vote :feature="feature"></vote>
    </li>
</template>
<style>

</style>
<script>
    import Vote from '../../features/components/components/vote.vue'
    import Tag from '../../features/components/components/tags.vue'
    export default{
        name: 'ReleasesListItem',
        components: {
            'vote': Vote,
            'tag': Tag
        },
        props: ['feature'],
        data(){
            return{

            }
        },
        computed: {

            /**
             * Computes status
             */
            status() {
                return this.feature.status!=null?this.feature.status.type:'PENDING';
            },

            /**
             * Computes status class
             */
            statusClass() {
                if(this.status==null) return 'status-pending';
                return {
                    'status-released': this.status=='RELEASED',
                    'status-wip': this.status=='WIP',
                    'status-pending': this.status=="PENDING",
                    'status-declined': this.status=='DECLINED'
                }
            },

            /**
             * Computes feature url
             *
             * @returns {string}
             */
            featureUrl() {
                return '/products/'+this.feature.product_id+'/features/' + this.feature.id;
            },

            /**
             * Computes product URL
             *
             * @returns {string}
             */
            productUrl() {
                return '/products/'+this.feature.product_id+'/features';
            }
        }
    }
</script>
