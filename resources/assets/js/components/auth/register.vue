<template>
        <section class="main-content">
            <div class="banner blue darken-2">
                <div class="container">
                    <div class="feature-req">
                        <div class="center-align feature-form-area">
                            <h2 class="feature-req-title">Sign Up</h2>
                        </div>
                    </div><!--/.feature-req-->
                </div>
            </div><!--/.banner-->

            <div class="container">
                <div class="signup">
                    <div class="row">
                        <div class="col s6 offset-s3">
                            <div class="card feature-list">
                                <div class="login-section card-content">

                                    <form action="">
                                        <div class="input-field">
                                            <input id="name" v-model="name" type="text" class="validate" placeholder="Your Name">
                                            <label for="name">Name</label>
                                        </div><!--/.input-field-->
                                        <div class="input-field">
                                            <input id="remail" v-model="email" type="email" class="validate" placeholder="Your Email">
                                            <label for="remail">Email</label>
                                        </div><!--/.input-field-->

                                        <div class="input-field">
                                            <input id="rpassword" v-model="password" type="password" class="validate" placeholder="Password">
                                            <label for="rpassword">Password</label>
                                        </div><!--/.input-field-->

                                        <div class="input-field">
                                            <input id="crpassword" v-model="password_confirmation" type="password" class="validate" placeholder="Password">
                                            <label for="crpassword">Confirm Password</label>
                                        </div><!--/.input-field-->

                                        <div class="input-field">

                                            <a class="btn btn-block" @click="signUp" :disabled="busy">Sign Up <spinner v-if="busy"></spinner></a>

                                        </div><!--/.input-field-->
                                    </form>
                                </div>
                            </div><!--/.card-->

                        </div><!--/.col-->
                    </div>
                </div><!--/.feature-req-->
            </div>
        </section>
</template>
<script type="text/babel">
    import Hunt from '../../config/Hunt'
    export default{
        data(){
            return{
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                busy: false
            }
        },
        mounted() {
            Hunt.renderPage('Sign Up');
        },
        methods: {
            /**
             * Validates inputs
             */
            validateInputs() {
                let ok = true;
                if(this.name=='') {
                    Hunt.toast('The name field is required.', 'warning');
                    ok = false;
                }
                else if(this.name.length<3) {
                    Hunt.toast('The name has to be at least 3 letters.', 'warning')
                }
                if(this.email=='') {
                    Hunt.toast('The email field is required.', 'warning');
                    ok = false;
                }
                else if (!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(this.email)) {
                    Hunt.toast('The email you entered is not valid.', 'warning');
                    ok = false;
                }
                if(this.password=='') {
                    Hunt.toast('The password field is required.', 'warning');
                    ok = false;
                }
                else if(this.password.length < 8) {
                    Hunt.toast('The password has to be at least 8 characters.', 'warning');
                    ok = false;
                }
                if(this.password != this.password_confirmation) {
                    Hunt.toast('The passwords did not match.', 'warning');
                    ok = false;
                }
                return ok;
            },
            /**
             * Performs registration action
             *
             * @param e
             */
            signUp(e) {
                if(!this.validateInputs()) return;
                this.busy = true;
                let that = this;
                this.$http.post('/auth/register',
                    {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation
                    })
                    .then(
                        success => {
                            Hunt.toast(success.body.message, 'success');
                            that.busy = false;
                            that.$router.push('/login');
                        },
                        error => {
                            console.log(error);

                            if(error.status == 422) {
                                _.each(error.body, (field) => {
                                    Hunt.toast(field[0], 'error');
                                })
                            } else {
                                Hunt.toast('Something went wrong (register)', 'error');
                            }

                            that.busy=false;
                        }
                    );
            }
        }
    }
</script>
