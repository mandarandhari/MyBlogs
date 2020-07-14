<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="/startbootstrap-clean-blog-jekyll/">MyBlogs</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fa fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <router-link class="nav-link" to="/home">Home</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/about">About</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/posts">Posts</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/contact">Contact</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <router-view :key="$route.fullPath"></router-view>
        <vue-progress-bar></vue-progress-bar>

        <!-- Footer -->

        <hr>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-10 mx-auto">
                        <ul class="list-inline text-center">
                    
                            <li class="list-inline-item">
                                <a href="mailto:your-email@example.com">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="far fa-envelope fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
            
            
                            <li class="list-inline-item">
                                <a href="https://twitter.com/SBootstrap">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
            
            
                            <li class="list-inline-item">
                                <a href="https://www.facebook.com/StartBootstrap">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
            
            
            
                            <li class="list-inline-item">
                                <a href="https://github.com/StartBootstrap">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
            
            
                        </ul>
                        <p class="copyright text-muted">Copyright &copy; Start Bootstrap 2020</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
    export default {
        mounted() {
            
        }
    }
</script>
