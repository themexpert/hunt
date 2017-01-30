<template>
    <div class="center-align feature-form-area">
        <h2 class="feature-req-title">Feature requests for ThemeXpert</h2>
        <!-- Modal Trigger -->
        <a class="waves-effect waves-light btn red" href="#modal1"><i class="material-icons left">add</i> Suggest a feature</a>

        <!-- Modal Structure -->
        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4 class="modal-title">Suggest a feature for ThemeXpert</h4>
                <form class="" action="">
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="suggest_feature" type="text" placeholder="What do you have in mind ?">
                            <label for="suggest_feature">Suggest a feature</label>
                        </div>
                        <div class="input-field col s6">
                            <products :selected="null"></products>
                        </div>
                    </div><!--/.row-->
                    <div class="input-field">
                        <textarea id="textarea1" class="materialize-textarea" placeholder="Please keep this as details as possible ..."></textarea>
                        <label for="textarea1">Add details (if you need to)</label>
                    </div>

                    <div class="input-field left-align">
                        <button type="submit" class="btn">Tell ThemeXpert I want this <i class="material-icons left">done</i> </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<style>
    
</style>
<script>
    import products from './products.vue'
    export default{
        components: {
            'products': products
        },
        data(){
            return{

            }
        }
    }
</script>
