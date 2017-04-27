<template>
    <section class="main-content">
        <div class="banner blue darken-2">
            <div class="container">
                <div class="feature-req">
                    <div class="center-align feature-form-area">
                        <h2 class="feature-req-title" v-text="lang.auth.form.login.title">Login</h2>
                    </div>
                </div><!--/.feature-req-->
            </div>
        </div><!--/.banner-->

        <div class="container">
            <div class="login">
                <div class="row">
                    <div class="col s6 offset-s3">
                        <div class="card feature-list">
                            <div class="login-section card-content">
                                <div class="center-align">
                                    <a href="/auth/google/" class="google-login">
                                        <div class="icon">
                                            <img src="/images/google-icon.png" alt="Google">
                                        </div>
                                        <div class="text" v-text="lang.auth.form.login.google_login">Sign in with Google</div>
                                    </a>
                                    <div class="or" v-text="lang.auth.form.login.or">OR</div>
                                </div>
                                <form action="">
                                    <div class="input-field">
                                        <input id="lemail" v-model="email" type="email" class="validate" :placeholder="lang.auth.form.login.email.placeholder">
                                        <label for="lemail" v-text="lang.auth.form.login.email.label">Email</label>
                                    </div><!--/.input-field-->

                                    <div class="input-field">
                                        <input id="lpassword" v-model="password" type="password" class="validate" :placeholder="lang.auth.form.login.password.placeholder">
                                        <label for="lpassword" v-text="lang.auth.form.login.password.label">Password</label>
                                    </div><!--/.input-field-->

                                    <div class="row">
                                        <div class="col s6">
                                            <div class="remember">
                                                <input type="checkbox" id="remember" v-model="remember" />
                                                <label for="remember" v-text="lang.auth.form.login.remember_me">Remember Me</label>
                                            </div><!--/.input-field-->
                                        </div>

                                        <div class="col s6 right-align">
                                            <a href="/auth/password/reset" v-text="lang.auth.form.login.forgot_password">Forgot Your Password?</a>
                                        </div>
                                    </div>

                                    <div class="input-field">

                                        <a class="btn btn-block" @click="login" :disabled="busy"><span v-text="lang.auth.form.login.btn_login">Log In</span> <spinner v-if="busy"></spinner></a>

                                    </div><!--/.input-field-->
                                </form>
                            </div>
                        </div><!--/.card-->
                        <div class="singup">
                            <div class="right-align"><span v-text="lang.auth.form.login.dont_have_an_account">Don’t have an account?</span> <router-link class="waves-effect waves-light btn red" to="/register" v-text="lang.auth.form.login.url_sign_up">Sign Up</router-link></div>
                        </div>
                    </div><!--/.col-->
                </div>
            </div><!--/.feature-req-->
        </div>
    </section>
</template>
<style>
    .google-login {
        background: #1976D2;
        color: #fff;
        display: flex;
        align-items: center;
        padding: 2px;
        font-family: 'Roboto', sans-serif;
        font-weight: 500;
        font-size: 16px;
        text-decoration: none;
        border-radius: 3px;
        width: 230px;
        margin: 0 auto;
        transition: all .3s ease;
    }
    .google-login .icon {
        background: #fff;
        margin-right: 22px;
        padding: 12px;
        border-radius: 3px;
        line-height: 1;
    }
    .google-login:hover {
        box-shadow: 0 0 3px 3px rgba(66,133,244,.3);
    }
</style>
<script>
    import Hunt from '../../config/Hunt'
    export default{
        data(){
            return{
                email: '',
                password: '',
                remember: false,
                busy: false
            }
        },
        mounted() {
            Hunt.renderPage('Login');
            this.email = Hunt.storage.get('email');
        },
        methods: {
            /**
             * Validates inputs
             */
            validateInputs() {
                let ok = true;
                if (this.email == '') {
                    Hunt.toast('The email field is required.', 'warning');
                    ok = false;
                }
                else if (!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(this.email)) {
                    Hunt.toast('The email you entered is not valid.', 'warning');
                    ok = false;
                }
                if (this.password == '') {
                    Hunt.toast('The password field is required.', 'warning');
                    ok = false;
                }
                else if (this.password.length < 8) {
                    Hunt.toast('The password has to be at least 8 characters.', 'warning');
                    ok = false;
                }
                return ok;
            },
            /**
             * Performs login action
             *
             * @param e
             */
            login(e) {
                if (!this.validateInputs()) return;
                this.busy = true;
                let that = this;
                this.$http.post('/auth/login',
                    {
                        email: this.email,
                        password: this.password,
                        remember: this.remember
                    })
                    .then(
                        success => {
                            that.busy = false;
                            window.Laravel.csrfToken = success.body._token;
                            Hunt.toast('You have successfully logged in.', 'success');
                            Hunt.storage.set('email', that.email);
                            let redirectTo = that.$store.state.auth.redirectTo || '/';
                            if (redirectTo != null) that.$store.state.auth.redirectTo = null;
                            that.$store.dispatch('loggedIn', redirectTo);
                        },
                        error => {
                            that.busy = false;
                            if (error.body._token != undefined) window.Laravel.csrfToken = error.body._token;
                            Hunt.toast(error.body.message, 'error');
                        }
                    );
            }
        }
    }
</script>
