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
                        <li v-for="user in users" class="collection-item avatar" :class="statusClass">
                            <img :src="gravatar(user.email)" :alt="user.name" class="circle" height="35" width="35">
                            <h4 class="title">{{ user.name }}</h4>
                            <div class="description">
                                Email: {{ user.email }}
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
<script type="text/babel">
    import Hunt from '../../config/Hunt'
    export default{
        name: 'Users',
        data(){
            return{
                users: []
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
            this.loadUsers();

            Hunt.renderPage('Users');
        },
        methods: {
            /**
             * Load all users.
             */
            loadUsers() {
                 this.get('/users')
                    .then(
                        success => {
                         this.users = success.body
                         console.log(success.body)
                        }
                    );
            },
            /**
             * Gravatar URL from email
             *
             * @param email
             * @param size
             * @returns {string}
             */
            gravatar(email, size) {
                return 'http://gravatar.com/avatar/'+Hunt.md5(email)+'?r=pg&d=mm'+(size?'&s='+size:'');
            },
        }
    }
</script>
