<template>
    <li class="collection-item avatar" :class="statusClass">
        <status-icon :status="item.status"></status-icon>
        <h4 class="title"><a href="#">{{ item.name }}</a></h4>
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
            statusClass() {
                return {
                    'status-released': this.item.status=='released',
                    'status-wip': this.item.status=='wip',
                    'status-pending': this.item.status==null
                }
            }
        }
    }
</script>
