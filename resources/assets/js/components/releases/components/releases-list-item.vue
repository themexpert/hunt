<template>
    <li class="collection-item avatar" :class="statusClass">
        <i class="material-icons circle">done</i>
        <h4 class="title"><router-link :to="productUrl">{{ item.product.name }}</router-link>: <router-link :to="featureUrl">{{ item.name }}</router-link></h4>
        <tag :tags="item.tags"></tag>
        <div class="description">
            {{ item.description }}
        </div>
        <vote :item-id="item.id"></vote>
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
        props: ['item'],
        data(){
            return{

            }
        },
        computed: {

            /**
             * Computes status
             */
            status() {
                return this.item.status!=null?this.item.status.type:'PENDING';
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
                return '/products/'+this.item.product_id+'/features/' + this.item.id;
            },

            /**
             * Computes product URL
             *
             * @returns {string}
             */
            productUrl() {
                return '/products/'+this.item.product_id+'/features';
            }
        }
    }
</script>
