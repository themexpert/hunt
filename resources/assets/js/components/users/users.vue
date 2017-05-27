<template>
    <section class="main-content">
        <div class="banner blue darken-2">
            <div class="container">
                <div class="feature-req">
                      <div class="center-align feature-form-area">
                            <h2 class="feature-req-title" v-text="lang.title_text.product_list">Users list of ThemeXpert</h2>
                        </div>
                </div><!--/.feature-req-->
            </div><!--/.container-->
        </div><!--/.banner-->

        <div class="container">
            <div class="feature-list card">
                <div class="details">
                    <ul class="collection products-list">


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
    export default{
        name: 'Products',
        data(){
            return{
            }
        },
        mounted() {
            /**
             * Check for admin access
             */
            if(!this.isAdmin) {
                Hunt.toast('You can not access this route.', 'info');
                this.$router.push('/');
                return;
            }
            Hunt.renderPage('Products');
        },
        methods: {

        },
        computed: {
            /**
             * Gived products list from store
             *
             * @returns {computed.products|products|{index}|Array|*}
             */
            products() {
                return this.$store.state.features.products;
            }
        }
    }
</script>
