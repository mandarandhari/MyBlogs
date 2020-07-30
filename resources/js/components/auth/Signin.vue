<template>
    <div id="main-div">
        <!-- Page Header -->

        <header class="masthead" style="background-image: url('/img/bg-login.jpg')">
        
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-10 mx-auto">
                        <div class="page-heading">
                            <h1>Signin</h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div id="error" v-if="error">
                        <div class='alert alert-danger'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <strong>{{ errorMsg }}</strong>
                        </div>
                    </div>
                    <form name="signin" id="signinForm" novalidate @submit.prevent="signin">
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label>Email Address</label>
                                <input type="email" class="form-control" placeholder="Email Address" id="email" v-model="email" required>
                                <p class="help-block text-danger" v-if="errors.email">{{ errors.email[0] }}</p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>password</label>
                                <input type="password" class="form-control" placeholder="password" id="Password" v-model="password" required>
                                <p class="help-block text-danger" v-if="errors.password">{{ errors.password[0] }}</p>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="signinButton">{{ signInBtnText }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto text-center">
                    <p>Don't have account? <router-link to="/signup" style="color: #3490dc !important;">Sign up</router-link></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                email: '',
                password: '',
                errors: {},
                error: false,
                errorMsg: '',
                signInBtnText: 'Sign in'
            }
        },
        methods: {
            signin() {
                var spinner = document.createElement('i');
                spinner.className = 'fa fa-spinner fa-spin spinner';
                this.signInBtnText = ' Please Wait';
                $('#signinButton').prepend(spinner);
                $('#signinButton').attr('disabled', 'disabled');

                axios.post('/api/signin', {
                    email: this.email,
                    password: this.password
                })
                .then((response) => {
                    $('.spinner').remove();
                    $('#signinButton').attr('disabled', false);
                    this.signInBtnText = "Sign in";

                    if (response.data.success) {
                        this.$store.commit('CustomerLoggedIn', response.data);
                        
                        localStorage.getItem('articleUrl') == null ? this.$router.push('/home') : this.$router.push( '/post/' + localStorage.getItem('articleUrl') );
                    } else {
                        this.error = true;
                        this.errorMsg = response.data.message;
                    }
                })
                .catch((errors) => {
                    $('.spinner').remove();
                    $('#signinButton').attr('disabled', false);
                    this.signInBtnText = "Sign in";

                    if (errors.response.status == 422) {
                        this.errors = errors.response.data.errors;
                    }
                });
            }
        },
        mounted() {
            this.$Progress.finish();

            $('html, body').animate({
                scrollTop: $('#main-div').offset().top - 100
            }, 1000);
        },
        created() {
            this.$Progress.start();
        }
    }
</script>
