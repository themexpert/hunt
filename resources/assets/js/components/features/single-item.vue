<template>
    <section class="main-content single-item">
        <div class="banner blue darken-2">
            <div class="container">
                <div class="feature-req">
                    <feature-request-modal></feature-request-modal>
                </div><!--/.feature-req-->
            </div>
        </div><!--/.banner-->

        <div class="container mt30">
            <div class="row">
                <feature :feature="feature"></feature>
                <sidebar :feature="feature"></sidebar>
            </div>
        </div>
    </section>
</template>
<style>
    
</style>
<script type="text/babel">
    import Hunt from '../../config/Hunt'
    import FeatureRequestModal from './components/feature-request-modal.vue'
    import feature from './components/feature.vue'
    import sidebar from './components/sidebar.vue'
    export default{
        name: 'SingleFeatureItem',
        components: {
            'feature-request-modal': FeatureRequestModal,
            'feature': feature,
            'sidebar': sidebar
        },
        data(){
            return {
                feature: null
            }
        },
        mounted () {
            Hunt.renderPage('Feature');
            if(!this.$store.state.features.features.length)
                this.$store.dispatch('product_changed', this.product_id);
            this.loadFeatureData();
            Bus.$on('new-vote', vote=>{
                    if(this.feature.vote===null) this.feature.vote = {up: 0, down: 0};
                    if(this.feature.userVoted===0) {
                        if(vote.up)
                            this.feature.vote.up++;
                        else
                            this.feature.vote.down++;
                    }
                    else {
                        if (vote.up === 1) {
                            this.feature.vote.up++;
                            this.feature.vote.down--;
                        }
                        else {
                            this.feature.vote.up--;
                            this.feature.vote.down++;
                        }
                    }
                    this.feature.userVoted = vote.up?1:-1;
            });
            Bus.$on("feature-updated", n_feature=>{
                this.feature.name = n_feature.name;
                this.feature.description = n_feature.description;
                this.feature.tags = n_feature.tags;
            });
        },
        methods: {
            /**
             * Loads feature information
             */
            loadFeatureData() {
                if(!(this.feature_id/2)) {
                    this.$router.push('/404');
                    return;
                }
                this.get('/products/'+this.product_id+'/features/'+this.feature_id)
                    .then(
                        success => {
                            if(success.body.features===null) {
                                this.$router.push('/404');
                                return;
                            }
                            success.body.features.tags = success.body.features.tags.map(tag=>{return tag.name;});
                            this.feature = success.body.features;
                            Hunt.renderPage(this.feature.name);
                        },
                        fail => {
                            Hunt.toast('Error loading feature information.', 'error');
                            console.log(fail);
                        }
                    );
            }
        },
        computed: {
            /**
             * Gives product ID from route
             */
            product_id() {
                return this.$route.params.product_id;
            },
            /**
             * Gives feature ID from route
             *
             * @returns {*}
             */
            feature_id() {
                return this.$route.params.feature_id;
            }
        }
    }
</script>
