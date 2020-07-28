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
                        <router-link class="btn btn-primary float-left" :to="'/post/' + prevArticle.url" data-toggle="tooltip" data-placement="top" :title="prevArticle.title">&larr; Previous<span class="d-none d-md-inline"> Post</span></router-link>
                    </div>

                    <div v-if="nextArticleExists" class="clearfix">
                        <router-link class="btn btn-primary float-right" :to="'/post/' + nextArticle.url" data-toggle="tooltip" data-placement="top" :title="nextArticle.title">&rarr; Next<span class="d-none d-md-inline"> Post</span></router-link>
                    </div>

                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="pt-5">
                        <h1 class="mt-4">Comments</h1>
                        <hr>
                    </div>
                    <div class="row" v-if="$store.state.isLoggedIn">
                        <div class="col-md-12 mb-4">
                            <form @submit.prevent="addComment">
                                <div class="form-group">
                                    <textarea name="comment" v-model="comment" rows="5" placeholder="Add your comment here..." class="form-control"></textarea>
                                    <span class="text-danger" style="font-size: 15px;" v-if="addCommentError != ''">{{ addCommentError }}</span>
                                </div>
                                <div class="form-group clearfix">
                                    <button type="submit" class="btn btn-primary float-right">Add</button>
                                </div>
                            </form>
                            <div class="alert alert-success add-comment-success" v-if="addCommentSuccess">
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                <span class="text-success" style="font-size: 17px;">Comment added</span>
                            </div>
                            <div class="alert alert-danger add-comment-failure" v-if="addCommentFailure">
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                <span class="text-danger" style="font-size: 17px;">{{ addCommentFailureMsg }}</span>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div v-if="comments.length" id="comments-div">
                        <div class="row" v-for="comment in comments" :key="comment.id">
                            <Comment :customername="comment.name" :createdat="comment.created_at" :comment="comment.comment" />
                        </div>
                    </div>
                    <div class="row" v-if="!comments.length">
                        <div class="col-md-12 text-center mb-5">
                            <span style="font-size: 18px;">No comments added yet</span>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Comment from './Comment';

    export default {
        components: {
            Comment
        },
        data() {
            return {
                bgImage: '',
                article: {},
                prevArticleExists: false,
                nextArticleExists: false,
                prevArticle: {},
                nextArticle: {},
                comment: '',
                comments: {},
                addCommentError: '',
                addCommentSuccess: false,
                addCommentFailure: false,
                addCommentFailureMsg: ''
            }
        },
        methods: {
            getArticle() {
                axios.get('/api/getArticle/' + this.$route.params.blogUrl)
                .then((response) => {
                    if (response.data.success) {
                        this.bgImage = app_admin_url + '/storage/articleBanners/' + response.data.article.id + '/' + response.data.article.banner;
                        this.article = response.data.article;
                        this.prevArticleExists = response.data.prevArticle != null ? true : false;
                        this.nextArticleExists = response.data.nextArticle != null ? true : false;
                        this.prevArticle = this.prevArticleExists ? response.data.prevArticle : {};
                        this.nextArticle = this.nextArticleExists ? response.data.nextArticle : {};
                        this.comments = response.data.comments;

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
            },
            addComment() {
                this.addCommentError = '';

                axios.post('/api/addComment', {
                    comment: this.comment,
                    article_id: this.article.id
                }, {
                    headers: {
                        'Authorization': 'Bearer ' + this.$store.state.token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then((response) => {
                    this.comment = '';
                    if (response.data.success) {
                        this.addCommentSuccess = true;
                        
                        this.comments.unshift({
                            article_id: response.data.comment.article_id,
                            comment: response.data.comment.comment,
                            created_at: response.data.comment.created_at,
                            customer_id: response.data.comment.customer_id,
                            id: response.data.comment.id,
                            name: this.$store.state.customer.name
                        });
                    } else {
                        this.addCommentFailure = true;
                        this.addCommentFailureMsg = response.data.message;
                    }

                    setTimeout(function() {                        
                        this.addCommentSuccess = false;
                        this.addCommentFailure = false;
                        $('.add-comment-success, .add-comment-failure').hide();
                    }, 3000);
                })
                .catch((errors) => {
                    this.addCommentError = errors.response.data.errors.comment[0];
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
