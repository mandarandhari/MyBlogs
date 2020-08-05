<template>
    <div id="main-div">
        <!-- Page Header -->

        <header class="masthead" style="background-image: url('/img/bg-index.jpg')">
        
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-10 mx-auto">
                        <div class="page-heading">
                            <h1>MyBlogs</h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">               

                    <!-- Home Post List -->               

                    <article class="post-preview" v-for="article in articles" :key="article.id">
                        <router-link :to="'/post/' + article.url" v-if="article.is_premium == 'no'">
                            <h2 class="post-title">{{ article.title }}</h2>
                            
                            <h3 class="post-subtitle" v-if="article.description != null">{{ article.description }}</h3>
                            
                        </router-link>
                        <a :href="'/post/' + article.url" v-if="article.is_premium == 'yes'" @click.prevent="checkArticleRedirect(article.url)">
                            <h2 class="post-title">{{ article.title }}</h2>
                            
                            <h3 class="post-subtitle" v-if="article.description != null">{{ article.description }}</h3>
                        </a>
                        <p class="post-meta">Posted on {{ article.created_at | dateFormat }}</p>
                    </article>

                    <hr>   
                    <!-- Pager -->
                    <div class="clearfix">
                        <router-link class="btn btn-primary float-right" to="/posts">View All Posts &rarr;</router-link>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                articles: {}
            }
        },
        methods: {
            getLatestArticles() {
                axios.get('/api/getLatestArticles')
                .then((response) => {
                    this.articles = response.data.articles;
                })
                .catch(() => {

                });
            },
            async getCustomerData() {
                axios.get('/api/getCustomerData', {
                    headers: {
                        'Authorization': 'Bearer ' + this.$store.state.token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then((response) => {
                    this.$store.commit('updateProfile', response.data);
                })
                .catch(errors => {
                    if (errors.response.status == 401) {
                        this.$store.commit('CustomerLoggedOut');
                        this.$router.push('/home');
                    }
                });
            },
            checkArticleRedirect(url) {
                if (this.$store.state.isLoggedIn) {
                    if (this.$store.state.customer.is_paid == 'yes') {
                        this.$router.push('/post/' + url);
                    } else {
                        localStorage.setItem('articleUrl', url);
                        this.$router.push('/payment');
                    }
                } else {
                    localStorage.setItem('articleUrl', url);
                    this.$router.push('/signin');
                }
            }
        },
        mounted() {
            this.getLatestArticles();

            if (this.$store.state.isLoggedIn) {
                this.getCustomerData();
            }
            
            this.$Progress.finish();

            $('html, body').animate({
                scrollTop: $('#main-div').offset().top - 100
            }, 1000);
        },
        created() {
            this.$Progress.start();

            document.title = 'MyBlogs | Home';

            localStorage.removeItem('articleUrl');
        }
    }
</script>
