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
                            
                            <span class="meta">Posted on {{ article.created_at | dateFormat }}
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
                    <div class="row comment-main-div" v-if="$store.state.isLoggedIn">
                        <div class="col-md-12 mb-4">
                            <form @submit.prevent="!editMode ? addComment() : updateComment()">
                                <div class="form-group">
                                    <textarea name="comment" v-model="comment" rows="5" placeholder="Add your comment here..." class="form-control"></textarea>
                                    <span class="text-danger" style="font-size: 15px;" v-if="commentError != ''">{{ commentError }}</span>
                                </div>
                                <div class="form-group clearfix">
                                    <button type="submit" class="btn btn-primary float-right add-comment-btn" v-if="!editMode">{{ addBtnText }}</button>
                                    <button type="submit" class="btn btn-primary float-right update-comment-btn" v-if="editMode">{{ updateBtnText }}</button>
                                    <button type="button" class="btn btn-danger float-right mr-3" v-if="editMode" @click="cancelCommentEdit">Cancel</button>
                                </div>
                            </form>
                            <div class="alert alert-success comment-success" v-if="commentSuccess">
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                <span class="text-success" style="font-size: 17px;">{{ commentSuccessMsg }}</span>
                            </div>
                            <div class="alert alert-danger comment-failure" v-if="commentFailure">
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                <span class="text-danger" style="font-size: 17px;">{{ commentFailureMsg }}</span>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div v-if="comments.length" id="comments-div">
                        <div class="row" v-for="comment in comments" :key="comment.id">
                            <Comment :customername="comment.name" :createdat="comment.created_at" :comment="comment.comment" :customerid="comment.customer_id" @editcomment="editComment(comment.id)" @deletecomment="deleteCommentConfirmation(comment.id)" />
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

        <div class="modal fade" id="deleteCommentModal" tabindex="-1" role="dialog" aria-labelledby="deleteCommentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteCommentModalLabel">Delete Comment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="font-size: 17px;">
                        Do you want to delete this comment?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger delete-comment-btn" @click="deleteComment">{{ deleteBtnText }}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
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
                commentId: '',
                commentError: '',
                commentSuccess: false,
                commentSuccessMsg: '',
                commentFailure: false,
                commentFailureMsg: '',
                editMode: false,
                addBtnText: 'Add',
                updateBtnText: 'Update',
                deleteBtnText: 'Yes'
            }
        },
        methods: {
            getArticle() {
                axios.get('/api/getArticle/' + this.$route.params.blogUrl)
                .then((response) => {
                    if (response.data.success) {
                        this.bgImage =  response.data.article.banner_url;
                        this.article = response.data.article;
                        this.prevArticleExists = response.data.prevArticle != null ? true : false;
                        this.nextArticleExists = response.data.nextArticle != null ? true : false;
                        this.prevArticle = this.prevArticleExists ? response.data.prevArticle : {};
                        this.nextArticle = this.nextArticleExists ? response.data.nextArticle : {};
                        this.comments = response.data.comments;

                        document.title = 'MyBlogs | ' + this.article.title;

                        $('html, body').animate({
                            scrollTop: $('#main-div').offset().top - 50
                        }, 'slow');
                    }
                })
                .catch((errors) => {
                    console.log(errors.response);
                });
            },
            getCustomerData() {
                return axios.get('/api/getCustomerData', {
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
            async checkArticleForPremium() {
                if (this.$store.state.isLoggedIn) {
                    await this.getCustomerData();
                }

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
            createSpinner(method) {
                var spinner = document.createElement('i');
                spinner.className = 'fa fa-spinner fa-spin spinner';

                switch (method) {
                    case 'add':
                        this.addBtnText = ' Adding';
                        $('.add-comment-btn').prepend(spinner);
                        $('.add-comment-btn').attr('disabled', 'disabled');
                        break;
                    
                    case 'update':
                        this.updateBtnText = '  Updating';
                        $('.update-comment-btn').prepend(spinner);
                        $('.update-comment-btn').attr('disabled', 'disabled');
                        break;
                    
                    case 'delete':
                        this.deleteBtnText = '  Loading';
                        $('.delete-comment-btn').prepend(spinner);
                        $('.delete-comment-btn').attr('disabled', 'disabled');
                        break;
                
                    default:
                        break;
                }
            },
            destroySpinner(method) {
                $('.spinner').remove();

                switch (method) {
                    case 'add':
                        $('.add-comment-btn').attr('disabled', false);
                        this.addBtnText = "Add";
                        break;

                    case 'update':
                        $('.update-comment-btn').attr('disabled', false);
                        this.updateBtnText = "Update";
                        break;

                    case 'delete':
                        $('.delete-comment-btn').attr('disabled', false);
                        this.deleteBtnText = "Yes";
                        break;
                    
                    default:
                        break;
                }
            },
            addComment() {
                this.commentError = '';

                this.createSpinner('add');

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
                    this.destroySpinner('add');

                    this.comment = '';
                    if (response.data.success) {
                        this.commentSuccess = true;
                        this.commentSuccessMsg = response.data.message;
                        
                        this.comments.unshift({
                            article_id: response.data.comment.article_id,
                            comment: response.data.comment.comment,
                            created_at: response.data.comment.created_at,
                            customer_id: response.data.comment.customer_id,
                            id: response.data.comment.id,
                            name: this.$store.state.customer.name
                        });
                    } else {
                        this.commentFailure = true;
                        this.commentFailureMsg = response.data.message;
                    }

                    setTimeout(function() {                        
                        this.commentSuccess = false;
                        this.commentFailure = false;
                        $('.comment-success, .comment-failure').hide();
                    }, 3000);
                })
                .catch((errors) => {
                    this.destroySpinner('add');

                    this.commentError = errors.response.data.errors.comment[0];
                });
            },
            editComment(comment_id) {
                $.each(this.comments, (i, v) => {
                    if (v.id == comment_id) {
                        this.commentId = comment_id;
                        this.comment = v.comment;
                        this.editMode = true;
                        this.commentError = '';
                        this.commentSuccess = false;
                        this.commentFailure = false;
                        this.commentFailureMsg = '';
                        
                        $('html, body').animate({
                            scrollTop: $('.comment-main-div').offset().top - 200
                        }, 200);
                    }
                });
            },
            updateComment() {
                this.createSpinner('update');

                axios.post('/api/updateComment', {
                    comment_id: this.commentId,
                    comment: this.comment
                }, {
                    headers: {
                        'Authorization': 'Bearer ' + this.$store.state.token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then((response) => {
                    this.destroySpinner('update');

                    if (response.data.success) {
                        this.commentSuccess = true;
                        this.commentSuccessMsg = response.data.message;

                        $.each(this.comments, (i, v) => {
                            if (v.id == this.commentId) {
                                v.comment = response.data.comment.comment;
                            }
                        });

                        this.editMode = false;
                        this.commentId = '';
                        this.comment = '';
                        this.commentError = '';

                        setTimeout(() => {
                            this.commentSuccess = false;
                            this.commentFailure = false;
                            $('.comment-success, .comment-failure').hide();
                        }, 3000);
                    } else {
                        this.commentFailure = true;
                        this.commentFailureMsg = response.data.message;
                    }
                })
                .catch((errors) => {
                    this.destroySpinner('update');

                    this.commentError = errors.response.data.errors.comment[0];
                });
            },
            cancelCommentEdit() {
                this.editMode = false;
                this.comment = '';
                this.commentId = '';
                this.commentError = '';
                this.commentSuccess = false;
                this.commentFailure = false;
                this.commentFailureMsg = '';
            },
            deleteCommentConfirmation(comment_id) {
                this.commentId = comment_id;
                $('#deleteCommentModal').modal('show');
            },
            deleteComment() {
                this.createSpinner('delete');

                axios.post('/api/deleteComment', {
                    'comment_id': this.commentId
                }, {
                    headers: {
                        'Authorization': 'Bearer ' + this.$store.state.token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then((response) => {
                    this.destroySpinner('delete');

                    if (response.data.success) {
                        $.each(this.comments, (i, v) => {
                            if (v.id == this.commentId) {
                                this.comments.splice(i, 1);
                                this.comment = '';
                                $('#deleteCommentModal').modal('hide');
                            }
                        });
                    }
                })
                .catch((errors) => {
                    this.destroySpinner('delete');
                    console.log(errors.response.data);
                });
            }
        },
        mounted() {
            this.$Progress.finish();

            $('#deleteCommentModal').on('hidden.bs.modal', () => {
                this.commentId = '';
            });
        },
        created() {
            this.$Progress.start();

            this.checkArticleForPremium();

            localStorage.removeItem('articleUrl');
        }
    }
</script>
