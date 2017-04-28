<template>
    <li class="collection-item avatar" :class="statusClass">
        <status-icon :status="status"></status-icon>
        <h4 class="title"><router-link :to="featureUrl">{{ feature.name }}</router-link>&nbsp;&nbsp;<router-link v-if="feature.product" :to="'/products/'+feature.product.id+'/features/'"><div class="chip grey darken-1" v-text="feature.product.name"></div></router-link></h4>
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
    import status_icon from './components/status-icon.vue'
    import Vote from './components/vote.vue'
    import Tag from './components/tags.vue'
    export default{
        name: 'FeatureListItem',
        components: {
            'status-icon': status_icon,
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
            }
        }
    }
</script>
