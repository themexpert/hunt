<template>
    <section class="main-content reports">
    <div class="banner blue darken-2">
        <div class="container">
            <div class="feature-req">
                <div class="center-align feature-form-area">
                    <h2 class="feature-req-title">Feature Reports</h2>
                </div>
            </div><!--/.feature-req-->
        </div>
    </div><!--/.banner-->

    <div class="container mt30">
        <div class="row">
            <div class="col s3">
                <div class="widget widget-feature-filter">
                    <h3 class="widget-title mt0">Feature Filter</h3>
                    <div class="filter-btn">
                        <a class="waves-effect waves-light btn">Any</a>
                        <a class="waves-effect waves-light btn">Private</a>
                        <a class="waves-effect waves-light btn">Public</a>
                    </div>
                </div><!--/.widget-->

                <div class="widget widget-feature-tags mt30">
                    <h3 class="widget-title">Feature Tags</h3>
                    <div class="filter-btn">
                        <a class="waves-effect waves-light btn">Tag 1</a>
                        <a class="waves-effect waves-light btn">Tag 2</a>
                        <a class="waves-effect waves-light btn">Tag 3</a>
                    </div>
                </div><!--/.widget-->
            </div>
            <div class="col s9">
                <div class="card mt0">
                    <div class="card-content report-table">
                        <table class="responsive-table">
                            <thead>
                            <tr>
                                <th data-field="value">Value</th>
                                <th data-field="feature">Feature</th>
                                <th data-field="status">Status</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td>
                                    <div class="progress tooltipped" data-tooltip="70%">
                                        <div class="determinate" style="width: 70%"></div>
                                    </div>
                                </td>
                                <td>
                                    <h4 class="title"><a href="#">Integration of intercom</a></h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
                                </td>
                                <td><span class="chip green">Building</span></td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="progress">
                                        <div class="determinate" style="width: 50%"></div>
                                    </div>
                                </td>
                                <td>
                                    <h4 class="title"><a href="#">Integration of intercom</a></h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
                                </td>
                                <td><span class="chip green">Building</span></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div><!--/.feature-req-->
            </div>
        </div>
    </div>
</section>
</template>
<style>
    
</style>
<script>
    import Hunt from '../../config/Hunt'
    export default{
        data(){
            return{
                msg:'hello vue'
            }
        },
        mounted() {
            Hunt.renderPage('Reports');
        }
    }
</script>
