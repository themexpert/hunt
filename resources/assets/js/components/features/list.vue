<template>
    <section class="main-content">
        <div class="banner blue darken-2">
            <div class="container">
                <div class="feature-req">
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
                                            <select>
                                                <option value="" disabled selected>Select a product</option>
                                                <option value="1">Option 1</option>
                                                <option value="2">Option 2</option>
                                                <option value="3">Option 3</option>
                                            </select>
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

                    <div class="feature-filter">
                        <div class="row">
                            <div class="col s9">
                                <div class="progress-link">
                                    <filters></filters>
                                </div>
                            </div>
                            <div class="col s3">
                                <div class="input-field">
                                    <products></products>
                                </div>
                            </div>
                        </div><!--/.row-->
                    </div><!--/.feature-list-->
                </div><!--/.feature-req-->
            </div><!--/.container-->
        </div><!--/.banner-->

        <div class="container">
            <div class="feature-list card">
                <div class="details">
                    <ul class="collection">

                        <li class="collection-item avatar status-released">
                            <i class="material-icons circle tooltipped" data-tooltip="Released">done</i>
                            <h4 class="title"><a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis</a></h4>
                            <div class="tags"><span class="chip">Tag1</span> <span class="chip green">Tag2</span></div>
                            <div class="description">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore, dolores, iste.
                            </div>

                            <div class="secondary-content">
                                <a class="waves-effect waves-light btn teal"><i class="material-icons left">done</i> I want this</a>
                                <a class="waves-effect waves-light btn teal lighten-2"><i class="material-icons left">snooze</i> Not interested</a>
                            </div>

                        </li>

                        <li class="collection-item avatar status-pending">
                            <i class="material-icons circle">schedule</i>
                            <h4 class="title"><a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus eligendi laudantium possimus ratione voluptas.</a></h4>
                            <div class="tags"><span class="chip">Tag1</span> <span class="chip green">Tag2</span></div>
                            <div class="description">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae cupiditate dolorem dolores eum facere facilis harum impedit maiores minima...
                            </div>

                            <div class="secondary-content">
                                <a class="waves-effect waves-light btn teal"><i class="material-icons left">done</i> I want this</a>
                                <a class="waves-effect waves-light btn teal lighten-2"><i class="material-icons left">snooze</i> Not interested</a>
                            </div>

                        </li>


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
    import filters from './components/filters.vue'
    import products from './components/products.vue'
    export default{
        components: {
            'filters': filters,
            'products': products
        },
        data(){
            return {

            }
        },
        mounted() {
            Hunt.renderPage('Feature Requests');
        }
    }
</script>
