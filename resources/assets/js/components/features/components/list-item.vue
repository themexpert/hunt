<template>
    <li class="collection-item avatar" :class="statusClass">
        <status-icon :status="status"></status-icon>
        <h4 class="title"><router-link :to="itemUrl">{{ item.name }}</router-link></h4>
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
             * Computes item url
             *
             * @returns {string}
             */
            itemUrl() {
                return '/features/' + this.item.id;
            }
        }
    }
</script>
