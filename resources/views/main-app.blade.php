<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>

            window.message = "<?php echo str_replace('"', '\\"', \Illuminate\Support\Facades\Session::get('message')); ?>";
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
                                <a id="logo-container" href="#" class="brand-logo">Logo</a>
                            </div>
                        </div><!--/.col-->
                        <div class="col s5">
                            <div class="search-box mt15">
                                <form>
                                    <div class="input-field">
                                        <input id="search" type="search" placeholder="Search Feature" required>
                                        <label for="search"><i class="material-icons">search</i></label>
                                        <i class="material-icons">close</i>
                                    </div>
                                </form>
                            </div>
                        </div><!--/.col-->
                        <div class="col s5">
                            <div class="menu mt15">
                                <div v-if="isLoggedIn" class="right author" v-cloak>
                                    <a href="#"><img :src="userAvatar" alt="" class="circle" height="25" width="25"></a>
                                    <a href="#">@{{ userName }}</a>
                                </div>

                                <ul class="right hide-on-med-and-down">
                                    <li><router-link to="/">Dashboard</router-link></li>
                                    <template v-if="isLoggedIn">
                                        <li><router-link to="/releases">Release</router-link></li>
                                        <li><router-link to="/reports">Report</router-link></li>
                                        <li><router-link to="/logout">Logout</router-link></li>
                                    </template>
                                    <template v-else>
                                        <li><router-link to="/login">Login</router-link></li>
                                        <li><router-link to="/register">Register</router-link></li>
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
    <router-view>
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
            <div class="container">
                &copy; 2010-2016 ThemeXpert Inc. All Rights Reserved.
            </div>
        </div>
    </footer>
</div>
<!-- Scripts -->
<script src="/js/app.js"></script>
</body>
</html>
