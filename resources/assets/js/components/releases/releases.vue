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
                        <releases-list-item v-for="feature in features" :item="feature"></releases-list-item>
                        <li v-if="features.length==0" class="text-center">No feature request found.</li>
                        <li style="text-align: center" v-if="loading"><preloader-2></preloader-2></li>
                    </ul><!--/.card-->
                </div><!--/.details-->
            </div><!--/.feature-req-->
        </div>
    </section>
</template>
<style>

</style>
<script type="text/babel">
    import Hunt from '../../config/Hunt'
    import featureRequestModal from '../features/components/feature-request-modal.vue'
    import releasesListItem from './components/releases-list-item.vue'
    import preloader_2 from '../preloader-2.vue'
    export default{
        name: 'Releases',
        components: {
            'feature-request-modal': featureRequestModal,
            'releases-list-item': releasesListItem,
            'preloader-2': preloader_2
        },
        data(){
            return{
                loading: true
            }
        },
        mounted() {
            Hunt.renderPage('Releases');
            /**
             * Perform initial load
             */
            this.$store.commit('loadReleasedFeatures');
            /**
             * Register infinite scroll
             */
            Hunt.infiniteScroll('.releases-list', ()=>{
                this.loading = true;
                this.$store.commit('loadReleasedFeatures', true);
            });
            /**
             * Register features list loaded listener
             *
             * @type {boolean}
             */
            Bus.$on('releases-list-loaded', ()=>{this.loading=false;});
        },
        computed: {
            /**
             * Gives features list from store
             *
             * @returns {computed.features|Array|*}
             */
            features() {
                return this.$store.state.releases.features;
            }
        }
    }
</script>
