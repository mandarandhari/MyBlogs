<template>
    <div>
        <!-- Page Header -->

        <header class="masthead" style="background-image: url('/img/bg-index.jpg')">
        
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-10 mx-auto">
                        <div class="page-heading">
                            <h1>MyBlogs</h1>
                            
                            <span class="subheading">A Blog Theme by Start Bootstrap</span>
                            
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
                        <router-link :to="'/blog/' + article.url">
                            <h2 class="post-title">{{ article.title }}</h2>
                            
                            <h3 class="post-subtitle" v-if="article.description != null">{{ article.description }}</h3>
                            
                        </router-link>
                        <p class="post-meta">Posted by Mandar on {{ article.created_at | dateFormat }}</p>
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
            getCustomerData() {
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
            }
        },
        mounted() {
            this.getLatestArticles();

            if (this.$store.state.isLoggedIn) {
                this.getCustomerData();
            }
            
            this.$Progress.finish();
        },
        created() {
            this.$Progress.start();
        }
    }
</script>
