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

            </div><!--/.col-->

            <div class="col s9">
                <div class="card mt0">
                    <div class="card-content settings-box">
                      <div class="general-settings">

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

                        <div class="favicon-change mt30">
                          <div class="file-field input-field">
                            <div class="btn">
                              <span>Upload Favicon</span>
                              <input type="file">
                            </div>
                            <div class="file-path-wrapper">
                              <input class="file-path validate" type="text" placeholder="Upload your favicon">
                            </div>
                          </div>
                        </div><!--/.favicon-change-->

                        <div class="mt30">
                          <div class="input-field">
                            <input id="company_name" type="text" value="ThemeXpert">
                            <label class="active" for="company_name">Company Name</label>
                          </div>
                        </div><!--/.mt30-->

                      </div><!--/.general-settings-->

                      <div class="profile-setting mt30">
                        <h5>Profile Settings</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                        <div class="mt30">
                          <div class="input-field">
                            <input id="change_name" type="text" value="Khandaker Ikrama">
                            <label class="active" for="change_name">Change Name</label>
                          </div>
                        </div><!--/.mt30-->

                        <div class="mt30">
                          <div class="input-field">
                            <input id="change_password" type="password" value="12345">
                            <label class="active" for="change_password">Change Password</label>
                          </div>
                        </div><!--/.mt30-->

                      </div><!--/.profile-settings-->
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
