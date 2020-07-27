<template>
    <div id="main-div">
        <header class="masthead" :style="'background-image: url(' + bgImage + ')'">
  
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-10 mx-auto">
                        <div class="post-heading">
                            <h1>{{ article.title }}</h1>
                            
                            <h2 class="subheading" v-if="article.description != null">{{ article.description }}</h2>
                            
                            <span class="meta">Posted by
                                <a href="#">Start Bootstrap</a>
                                on {{ article.created_at | dateFormat }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div v-html="article.content">
                        {{ article.content }}
                    </div>
                    <hr>

                    <div v-if="prevArticleExists">
                        <router-link class="btn btn-primary float-left" :to="'/blog/' + prevArticle.url" data-toggle="tooltip" data-placement="top" :title="prevArticle.title">&larr; Previous<span class="d-none d-md-inline"> Post</span></router-link>
                    </div>

                    <div v-if="nextArticleExists">
                        <router-link class="btn btn-primary float-right" :to="'/blog/' + nextArticle.url" data-toggle="tooltip" data-placement="top" :title="nextArticle.title">&rarr; Next<span class="d-none d-md-inline"> Post</span></router-link>
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
                bgImage: '',
                article: {},
                prevArticleExists: false,
                nextArticleExists: false,
                prevArticle: {},
                nextArticle: {}
            }
        },
        methods: {
            getArticle() {
                axios.get('/api/getArticle/' + this.$route.params.blogUrl)
                .then((response) => {
                    if (response.data.success) {
                        this.bgImage = 'http://admin.myblogs.local/storage/articleBanners/' + response.data.article.id + '/' + response.data.article.banner;
                        this.article = response.data.article;
                        this.prevArticleExists = response.data.prevArticle != null ? true : false;
                        this.nextArticleExists = response.data.nextArticle != null ? true : false;
                        this.prevArticle = this.prevArticleExists ? response.data.prevArticle : {};
                        this.nextArticle = this.nextArticleExists ? response.data.nextArticle : {};

                        $('html, body').animate({
                            scrollTop: $('#main-div').offset().top - 50
                        }, 'slow');
                    } else {
                        
                    }
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
            },
            checkArticleForPremium() {
                axios.get('/api/checkArticleForPremium/' + this.$route.params.blogUrl)
                .then((response) => {
                    if ( response.data.success ) {
                        if (response.data.is_premium == 'yes') {
                            if ( this.$store.state.isLoggedIn && this.$store.state.customer.is_paid == 'no' ) {
                                localStorage.setItem('articleUrl', this.$route.params.blogUrl);
                                this.$router.push('/payment');
                            } else if ( !this.$store.state.isLoggedIn ) {
                                localStorage.setItem('articleUrl', this.$route.params.blogUrl);
                                this.$router.push('/signin');
                            } else {
                                this.getArticle();
                            }
                        } else {
                            this.getArticle();
                        }
                    } else {
                        this.$router.push('/home');
                    }
                });
            }
        },
        mounted() {
            this.$Progress.finish();
        },
        created() {
            this.$Progress.start();
            
            if (this.$store.state.isLoggedIn) {
                this.getCustomerData();
            }

            this.checkArticleForPremium();            
        }
    }
</script>
