<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ $settings->favicon }}">

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token()
        ]); ?>

            window.message = "<?php echo str_replace('"', '\\"', \Illuminate\Support\Facades\Session::get('message')); ?>";
            window.company = "{{ str_replace('"', "\"", $settings->company) }}";
            window.copyright = "{{ str_replace('"', "\"", $settings->copyright) }}";
            window.language = "{{ $settings->language }}";
    </script>
    <title>Hunt</title>
    <style>
        [v-cloak] {
            display: none;
        }
    </style>
</head>
<body>
<div id="app">
    <header class="blue darken-2">
        <nav class="blue darken-2" role="navigation">
            <div class="container">
                <div class="nav-wrapper">
                    <div class="row">
                        <div class="col s2">
                            <div class="logo mt15">
                                <router-link id="logo-container" to="/" class="brand-logo">
                                    <img src="{{ $settings->logo }}" style="max-width: 200px" alt="logo">
                                </router-link>
                            </div>
                        </div><!--/.col-->
                        <div class="col s5" v-if="isLoggedIn">
                            <search></search>
                        </div><!--/.col-->
                        <div class="col" :class="{s10:!isLoggedIn,s5:isLoggedIn}">
                            <div class="menu mt15">
                                <div v-if="isLoggedIn" class="right author" v-cloak>
                                    <img :src="userAvatar" alt="" class="circle" height="25" width="25">
                                    <a data-activates="dropdown1" class="dropdown">@{{ userName }}</a>
                                    <ul id='dropdown1' class='dropdown-content'>
                                        <li v-if="isAdmin"><router-link to="/products" v-text="lang.nav.products">Products</router-link></li>
                                        <li v-if="isAdmin"><router-link to="/settings" v-text="lang.nav.settings">Settings</router-link></li>
                                        {{--<li v-if="isAdmin"><router-link to="/settings/token" v-text="lang.nav.tokens">Tokens</router-link></li>--}}
                                        <li v-if="isAdmin"><router-link to="/reports" v-text="lang.nav.reports">Reports</router-link></li>
                                        <li class="divider"></li>
                                        <li><router-link to="/logout" v-text="lang.auth.nav.logout">Logout</router-link></li>
                                    </ul>
                                </div>

                                <ul class="right hide-on-med-and-down">
                                    <template v-if="isLoggedIn">
                                        <li><router-link to="/" v-text="lang.nav.dashboard">Dashboard</router-link></li>
                                        <li><router-link to="/features/releases" v-text="lang.nav.releases">Releases</router-link></li>
                                    </template>
                                    <template v-else>
                                        <li><router-link to="/login" v-text="lang.auth.nav.login">Login</router-link></li>
                                        <li><router-link to="/register" v-text="lang.auth.nav.register">Register</router-link></li>
                                    </template>
                                </ul>
                            </div>
                        </div><!--/.col-->

                    </div><!--/.row-->

                    <ul id="nav-mobile" class="side-nav" style="transform: translateX(-100%);">
                        <li><a href="#">Navbar Link</a></li>
                    </ul>
                    <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
                </div><!--/.nav-wrapper-->
            </div><!--/.container-->
        </nav><!--/.nav-->
    </header>
    <router-view class="view" :key="$route.path">
        <div class="preloader-box">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div><!--/.preloader-wrapper-->
        </div>
    </router-view>
    <footer class="center-align">
        <div class="footer-copyright">
            <div class="container" v-html="lang.copyright">{{ $settings->copyright }}</div>
        </div>
    </footer>
</div>
<!-- Scripts -->
<script src="/js/app.js"></script>
</body>
</html>
