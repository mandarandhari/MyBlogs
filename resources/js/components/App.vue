<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="/home">MyBlogs</a>
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
                        <li class="nav-item" v-if="!$store.state.isLoggedIn">
                            <router-link class="nav-link" to="/signin">Signin</router-link>
                        </li>
                        <li class="nav-item dropdown" v-if="$store.state.isLoggedIn">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $store.state.customer.name }}</a>
                            <div class="dropdown-menu pt-0 pb-0" aria-labelledby="navbarDropdown">
                                <router-link to="/payment" class="dropdown-item text-decoration-none" v-if="$store.state.customer.is_paid == 'no'">Payment</router-link>
                                <router-link to="/profile" class="dropdown-item text-decoration-none">Profile</router-link>
                                <a href="#" class="dropdown-item text-decoration-none" @click.prevent="logout">Logout</a>
                            </div>
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
                                <a href="">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="far fa-envelope fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
            
            
                            <li class="list-inline-item">
                                <a href="">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
            
            
                            <li class="list-inline-item">
                                <a href="">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
            
            
            
                            <li class="list-inline-item">
                                <a href="">
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
        methods: {
            logout() {
                axios.post('/api/logout', {
                    
                }, {
                    headers: {
                        'Authorization': 'Bearer ' + this.$store.state.token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then((response) => {
                    if (response.data.success) {
                        this.$store.commit('CustomerLoggedOut');
                    } 

                    this.$router.push('/home');
                })
                .catch((errors) => {
                    if (errors.response.status == 401) {
                        this.$store.commit('CustomerLoggedOut');
                        this.$router.push('/home');
                    }
                });
            }
        }
    }
</script>
