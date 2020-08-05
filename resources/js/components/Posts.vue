<template>
    <div id="main-div">
        <!-- Page Header -->

        <header class="masthead" style="background-image: url('/img/bg-about.jpg')">
        
            <div class="overlay"></div>
            <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                <div class="page-heading">
                    <h1>Posts</h1>
                    
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
                    <div v-if="prevUrl != ''">
                        <button class="btn btn-primary float-left" @click.prevent="getArticles(prevUrl)">Newer Posts &larr;</button>
                    </div>
                    <div v-if="nextUrl != ''">
                        <button class="btn btn-primary float-right" @click.prevent="getArticles(nextUrl)">Older Posts &rarr;</button>
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
                articles: {},
                prevUrl: '',
                nextUrl: ''
            }
        },
        methods: {
            getArticles(url = '') {
                let param = url.length ? '?' + url : '';

                axios.get('/api/getArticles' + param)
                .then((response) => {
                    this.nextUrl = '';
                    this.prevUrl = '';

                    this.articles = response.data.articles.data;

                    if (response.data.articles.next_page_url != null) {
                        this.nextUrl = response.data.articles.next_page_url.split('?')[1];
                    }

                    if (response.data.articles.prev_page_url != null) {
                        this.prevUrl = response.data.articles.prev_page_url.split('?')[1];
                    }

                    $('html, body').animate({
                        scrollTop: $('#main-div').offset().top - 50
                    }, 'slow');
                })
                .catch(() => {

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
            this.getArticles();
            this.$Progress.finish();
        },
        created() {
            this.$Progress.start();

            document.title = 'MyBlogs | Posts';

            localStorage.removeItem('articleUrl');
        }
    }
</script>
