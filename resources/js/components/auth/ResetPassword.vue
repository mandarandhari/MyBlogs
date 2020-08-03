<template>
    <div id="main-div">
        <!-- Page Header -->

        <header class="masthead" style="background-image: url('/img/bg-reset-password.jpg')">
        
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-10 mx-auto">
                        <div class="page-heading">
                            <h1>Reset Password</h1>
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
                    <form name="resetPassword" id="resetPasswordForm" novalidate @submit.prevent="resetPassword">
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder="Password" id="email" v-model="password" required>
                                <p class="help-block text-danger" v-if="errors.password">{{ errors.password[0] }}</p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" placeholder="Confirm Password" id="confirmPassword" v-model="confirmPassword" required>
                                <p class="help-block text-danger" v-if="errors.confirmPassword">{{ errors.confirmPassword[0] }}</p>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="resetPasswordButton">{{ resetPasswordBtnText }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            password: '',
            confirmPassword: "",
            errors: {},
            error: false,
            success: false,
            errorMsg: '',
            successMsg: '',
            resetPasswordBtnText: 'Reset Password',
            customerId: null,
            tokenId: null
        }
    },
    methods: {
        async getCustomer() {
            axios.get('/api/getCustomer/' + this.$route.query.token)
            .then(response => {
                if (response.data.success) {
                    this.customerId = response.data.customer_id;
                    this.tokenId = response.data.token_id;
                } else {
                    this.$router.push('/home');
                }
            })
            .catch(error => {
                console.log(error.response);
            });
        },
        resetPassword() {
            var spinner = document.createElement('i');
            spinner.className = 'fa fa-spinner fa-spin spinner';
            this.resetPasswordBtnText = ' Please Wait';
            $('#resetPasswordButton').prepend(spinner);
            $('#resetPasswordButton').attr('disabled', 'disabled');

            axios.post('/api/resetPassword', {
                password: this.password,
                confirmPassword: this.confirmPassword,
                customerId: this.customerId,
                token_id: this.tokenId
            })
            .then(response => {
                $('.spinner').remove();
                $('#resetPasswordButton').attr('disabled', false);
                this.resetPasswordBtnText = "Reset Password";

                if (response.data.success) {
                    this.success = true;
                    this.successMsg = response.data.message;

                    setTimeout( () => {
                        this.$router.push('/signin');
                    }, 2500);
                } else {
                    this.error = true;
                    this.errorMsg = response.data.message;
                }
            })
            .catch(errors => {
                $('.spinner').remove();
                $('#resetPasswordButton').attr('disabled', false);
                this.resetPasswordBtnText = "Reset Password";

                this.errors = errors.response.data.errors;
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

        document.title = 'MyBlogs | Reset Password';

        if (this.$route.query.token != '') {
            this.getCustomer();
        } else {
            this.$router.push('/home');
        }
    }
}
</script>