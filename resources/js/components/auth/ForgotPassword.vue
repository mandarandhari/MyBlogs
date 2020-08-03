<template>
    <div id="main-div">
                <!-- Page Header -->

        <header class="masthead" style="background-image: url('/img/bg-forgot-password.jpg')">
        
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-10 mx-auto">
                        <div class="page-heading">
                            <h1>Forgot Password</h1>
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
                    <div id="success" v-if="success">
                        <div class='alert alert-success'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <strong>{{ successMsg }}</strong>
                        </div>
                    </div>
                    <form name="forgotPassword" id="forgotPasswordForm" novalidate @submit.prevent="forgotPassword">
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label>Email Address</label>
                                <input type="email" class="form-control" placeholder="Email Address" id="email" v-model="email" required>
                                <p class="help-block text-danger" v-if="errors.email">{{ errors.email[0] }}</p>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="forgotPasswordButton">{{ sendMailBtnText }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto text-center">
                    <p>Already have account? <router-link to="/signin" style="color: #3490dc !important;">Sign in</router-link></p>
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
            errors: {},
            error: false,
            success: false,
            errorMsg: '',
            successMsg: '',
            sendMailBtnText: 'Send Email'
        }
    },
    methods: {
        forgotPassword() {
            var spinner = document.createElement('i');
            spinner.className = 'fa fa-spinner fa-spin spinner';
            this.sendMailBtnText = ' Please Wait';
            $('#forgotPasswordButton').prepend(spinner);
            $('#forgotPasswordButton').attr('disabled', 'disabled');

            axios.post('/api/forgotPassword', {
                email: this.email
            })
            .then(response => {
                $('.spinner').remove();
                $('#forgotPasswordButton').attr('disabled', false);
                this.sendMailBtnText = "Send Email";

                if (response.data.success) {
                    this.email = '';
                    this.success = true;
                    this.successMsg = response.data.message;
                } else {
                    this.error = true;
                    this.errorMsg = response.data.message;
                }
            })
            .catch(error => {
                $('.spinner').remove();
                $('#forgotPasswordButton').attr('disabled', false);
                this.sendMailBtnText = "Send Email";

                this.errors = error.response.data.errors;
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

        document.title = 'MyBlogs | Forgot Password';
    }
}
</script>