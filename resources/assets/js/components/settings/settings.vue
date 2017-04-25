<template>
    <section class="main-content reports">
    <div class="banner blue darken-2">
        <div class="container">
            <div class="feature-req">
                <div class="center-align feature-form-area">
                    <h2 class="feature-req-title">Settings</h2>
                </div>
            </div><!--/.feature-req-->
        </div>
    </div><!--/.banner-->

    <div class="container mt30">
        <div class="row">
            <div class="col s3">

                <div class="center user-info">
                  <div class="user-av">
                    <img class="circle responsive-img" src="http://faker.im/200x200" alt="User Name">
                  </div>
                  <h4>User Name</h4>
                  <a href="#">Sign Out</a>
                </div><!--/.user-info-->

                <hr>

                <div class="general-settings mt30">
                  <h5>General Settings</h5>


                </div><!--/.general-settings-->

                <div class="profile-settings mt30">
                  <h5>Profile Settings</h5>
                </div><!--/.profile-info-->


            </div>

            <div class="col s9">
                <div class="card mt0">
                    <div class="card-content settings-box">
                      <h5 class="mt0">General Settings</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                      <div class="logo-change mt30">
                        <div class="file-field input-field">
                          <div class="btn">
                            <span>Upload Logo</span>
                            <input type="file">
                          </div>
                          <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload your logo">
                          </div>
                        </div>
                      </div><!--/.logo-change-->

                      <div class="profile-setting">
                        <h5>Profile Settings</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                      </div>
                    </div><!--settings-box-->
                </div><!--/.feature-req-->
            </div>
        </div>
    </div>
</section>
</template>s

<script>
    export default {
        mounted() {
            if(!this.isAdmin) {
                toastr.warning("You don't have access to that page.");
                this.$router.push('/');
            }
        }
    }
</script>
