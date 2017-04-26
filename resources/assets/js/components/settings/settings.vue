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
                    <img class="circle responsive-img" :src="userAvatar" :alt="username">
                  </div>
                  <h4 v-text="username"></h4>
                    <router-link to="/logout" v-text="lang.auth.nav.logout">Logout</router-link>
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
                              <input type="file" @change="setLogo">
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
                              <input type="file" @change="setFavicon">
                            </div>
                            <div class="file-path-wrapper">
                              <input class="file-path validate" type="text" placeholder="Upload your favicon">
                            </div>
                          </div>
                        </div><!--/.favicon-change-->

                          <div class="mt30">
                              <div class="input-field">
                                  <select id="language">
                                      <option value="en" :selected="langData.language==='en'">English</option>
                                      <option value="bn" :selected="langData.language==='bn'">বাংলা</option>
                                  </select>
                                  <label class="active" for="language">Language</label>
                              </div>
                          </div><!--/.mt30-->

                        <div class="mt30">
                          <div class="input-field">
                            <input id="company_name" type="text" v-model="company">
                            <label class="active" for="company_name">Company Name</label>
                          </div>
                        </div><!--/.mt30-->

                          <div class="mt30">
                              <div class="input-field">
                                  <input id="copyright" type="text"  v-model="copyright">
                                  <label class="active" for="copyright">Copyright</label>
                              </div>
                          </div><!--/.mt30-->

                      </div><!--/.general-settings-->

                      <div class="profile-setting mt30">
                        <h5>Profile Settings</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                        <div class="mt30">
                          <div class="input-field">
                            <input id="change_name" type="text" v-model="name">
                            <label class="active" for="change_name">Change Name</label>
                          </div>
                        </div><!--/.mt30-->

                        <div class="mt30">
                          <div class="input-field">
                            <input id="o_password" type="password" v-model="o_password">
                            <label class="active" for="o_password">Old Password</label>
                          </div>
                        </div><!--/.mt30-->
                          <div class="mt30">
                              <div class="input-field">
                                  <input id="c_password" type="password" v-model="c_password">
                                  <label class="active" for="c_password">New Password</label>
                              </div>
                          </div><!--/.mt30-->
                          <div class="mt30">
                              <div class="input-field">
                                  <button type="submit" class="btn" :disabled="busy" @click="setSettings"><span>Save Product</span> <spinner v-if="busy"></spinner></button>
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
    import Hunt from './../../config/Hunt'
    export default {
        data() {
            return {
                logo: null,
                favicon: null,
                company: '',
                copyright: '',
                name: '',
                language: 'en',
                o_password: '',
                c_password: '',
                busy: false
            }
        },
        mounted() {
            if(!this.isAdmin) {
                Hunt.toast("You don't have access to that page.", "warning");
                this.$router.push('/');
                return;
            }
            this.name = this.username;
            this.getSettings();
            Hunt.renderPage("Settings");
            Vue.nextTick(()=>{$("select").material_select();});
        },
        methods: {
            setLogo(e) {
                this.logo = e.target.files[0];
            },
            setFavicon(e) {
                this.favicon = e.target.files[0];
            },
            getSettings() {
                this.$http.get('/api/settings').then(response=>{
                    this.company = response.data.company;
                    this.copyright = response.data.copyright;
                    Vue.nextTick(()=>{Hunt.renderPage("Settings");});
                }).catch(error=>{console.log(error);});
            },
            prepare() {
                const lang = $("#language").val();
                this.language = lang;
                const data = new FormData();
                data.append('name', this.name);
                data.append('company', this.company);
                data.append('copyright', this.copyright);
                data.append('language', lang);
                if(this.logo!==null)
                    data.append('logo', this.logo);
                if(this.favicon!==null)
                    data.append('favicon', this.favicon);
                if(this.c_password.length) {
                    data.append('old_password', this.o_password);
                    data.append('new_password', this.c_password);
                }
                return data;
            },
            setSettings() {
                this.busy = true;
                const data = this.prepare();
                this.$http.post('/api/settings', data)
                    .then(response=>{
                        try {
                            Hunt.toast(response.data.message);
                            $("head link[rel='shortcut icon']").attr('href', response.data.favicon);
                            $("img[alt='logo']").attr('src', response.data.logo);
                            Bus.$emit("settings-updated", {company: response.data.company, copyright: response.data.copyright, LANG: this.language});
                            this.logo = null;
                            this.favicon = null;
                            $(".file-path").val('');
                            this.$store.state.auth.user.name = this.name;
                            $("input[type=password]").val('');
                            this.busy = false;
                        }catch(e) {
                            console.log(e);
                        }
                    })
                    .catch(error=>{
                        Hunt.toast(error.data, "error");
                        this.busy = false;
                    });
            }
        },
        computed: {
            username() {
                return this.$store.getters.userName;
            },

            /**
             * Returns gravatar URL for user
             *
             * @returns {string}
             */
            userAvatar() {
                return this.gravatar(this.$store.getters.userEmail, 200);
            },
        }
    }
</script>
