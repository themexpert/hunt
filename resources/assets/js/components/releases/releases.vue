<template>
    <section class="main-content">
        <div class="banner blue darken-2">
            <div class="container">
                <div class="feature-req">
                    <feature-request-modal></feature-request-modal>
                </div><!--/.feature-req-->
            </div><!--/.container-->
        </div><!--/.banner-->

        <div class="container">
            <div class="feature-list card">
                <div class="details">
                    <ul class="collection releases-ist">
                        <feature-list-item v-for="feature in features" :item="feature"></feature-list-item>
                        <li v-if="features.length==0" class="text-center">No feature request found.</li>
                        <li v-if="loading"><preloader-2></preloader-2></li>
                    </ul><!--/.card-->
                </div><!--/.details-->
            </div><!--/.feature-req-->
        </div>
    </section>
</template>
<style>
    
</style>
<script>
    import Hunt from '../../config/Hunt'
    import featureRequestModal from '../features/components/feature-request-modal.vue'
    import featureListItem from '../features/components/list-item.vue'
    import preloader_2 from '../preloader-2.vue'
    export default{
        name: 'Releases',
        components: {
            'feature-request-modal': featureRequestModal,
            'feature-list-item': featureListItem,
            'preloader-2': preloader_2
        },
        data(){
            return{
                loading: true
            }
        },
        mounted() {
            Hunt.renderPage('Releases');
            this.$store.commit('loadReleasedFeatures');
            Hunt.infiniteScroll('.releases-list', ()=>{
                this.loading = true;
                this.$store.commit('loadReleasedFeatures', true);
            });
            Bus.$on('feature-list-loaded', ()=>{this.loading=false;});
        },
        computed: {
            features() {
                return this.$store.state.releases.features;
            }
        }
    }
</script>
