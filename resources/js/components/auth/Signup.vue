<template>
    <div id="main-div">
        <!-- Page Header -->

        <header class="masthead" style="background-image: url('/img/bg-register.jpg')">
        
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-10 mx-auto">
                        <div class="page-heading">
                            <h1>Signup</h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <form name="signup" id="signupForm" novalidate @submit.prevent="signup">
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Name" id="name" v-model="name" required>
                                <p class="help-block text-danger" v-if="errors.name">{{ errors.name[0] }}</p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label>Email Address</label>
                                <input type="email" class="form-control" placeholder="Email Address" id="email" v-model="email" required>
                                <p class="help-block text-danger" v-if="errors.email">{{ errors.email[0] }}</p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Phone Number</label>
                                <input type="tel" class="form-control" placeholder="Phone Number" id="phone" v-model="phone" required>
                                <p class="help-block text-danger" v-if="errors.phone">{{ errors.phone[0] }}</p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>password</label>
                                <input type="password" class="form-control" placeholder="Password" id="password" v-model="password" required>
                                <p class="help-block text-danger" v-if="errors.password">{{ errors.password[0] }}</p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>confirmPassword</label>
                                <input type="password" class="form-control" placeholder="Confirm Password" id="confirmPassword" v-model="confirmPassword" required>
                                <p class="help-block text-danger" v-if="errors.confirmPassword">{{ errors.confirmPassword[0] }}</p>
                            </div>
                        </div>
                        <br>
                        <div id="error" v-if="error">
                            <div class='alert alert-danger'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                <strong>{{ errorMsg }}</strong>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="signupButton">{{ signUpBtnText }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto text-center">
                    <p>Already have account? <router-link to="/signin" style="color: #3490dc !important;">Sign in</router-link></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: '',
                email: '',
                phone: '',
                password: '',
                confirmPassword: '',
                errors: {},
                error: false,
                errorsMsg: '',
                signUpBtnText: 'Sign up'
            }
        },
        methods: {
            signup() {
                var spinner = document.createElement('i');
                spinner.className = 'fa fa-spinner fa-spin spinner';
                this.signUpBtnText = ' Please Wait';
                $('#signupButton').prepend(spinner);
                $('#signupButton').attr('disabled', 'disabled');

                axios.post('/api/signup', {
                    name: this.name,
                    email: this.email,
                    phone: this.phone,
                    password: this.password,
                    confirmPassword: this.confirmPassword
                })
                .then((response) => {
                    $('.spinner').remove();
                    $('#signupButton').attr('disabled', false);
                    this.signUpBtnText = "Sign up";

                    if (response.data.success) {
                        this.$store.commit('CustomerLoggedIn', response.data);

                        if (this.$store.state.customer.is_paid == 'yes') {
                            localStorage.getItem('articleUrl') == null ? this.$router.push('/home') : this.$router.push( '/post/' + localStorage.getItem('articleUrl') );
                        } else {
                            localStorage.getItem('articleUrl') == null ? this.$router.push('/home') : this.$router.push('/payment');
                        }
                    }
                })
                .catch((errors) => {
                    $('.spinner').remove();
                    $('#signupButton').attr('disabled', false);
                    this.signUpBtnText = "Sign up";

                    if (errors && errors.response.status == 422) {
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

            document.title = 'MyBlogs | Signup';
        }
    }
</script>
