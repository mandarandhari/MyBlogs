<template>
    <div>
        <!-- Page Header -->

        <header class="masthead" style="background-image: url('/img/bg-profile.jpg')">
        
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-10 mx-auto">
                        <div class="page-heading">
                            <h1>Profile</h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">

                    <form name="profile" id="profileForm" novalidate @submit.prevent="updateProfile">
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
                                <input type="password" class="form-control" placeholder="password" id="password" v-model="password" required>
                                <p class="help-block text-danger" v-if="errors.password">{{ errors.password[0] }}</p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>confirmPassword</label>
                                <input type="password" class="form-control" placeholder="confirmPassword" id="confirmPassword" v-model="confirmPassword" required>
                                <p class="help-block text-danger" v-if="errors.confirmPassword">{{ errors.confirmPassword[0] }}</p>
                            </div>
                        </div>
                        <br>
                        <div id="success" v-if="success">
                            <div class='alert alert-success'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                <strong>{{ successMsg }}</strong>
                            </div>
                        </div>
                        <div id="error" v-if="error">
                            <div class='alert alert-danger'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                <strong>{{ errorMsg }}</strong>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary profile-update-btn" id="profileButton">{{ updateBtnText }}</button>
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
                name: this.$store.state.customer.name,
                email: this.$store.state.customer.email,
                phone: this.$store.state.customer.phone,
                password: '',
                confirmPassword: '',
                errors: {},
                error: false,
                success: false,
                errorMsg: '',
                successMsg: '',
                updateBtnText: "Update"
            }
        },
        methods: {
            updateProfile() {
                this.success = false;
                this.error = false;

                var spinner = document.createElement('i');
                spinner.className = 'fa fa-spinner fa-spin spinner';
                this.updateBtnText = ' Updating';
                $('.profile-update-btn').prepend(spinner);
                $('.profile-update-btn').attr('disabled', 'disabled');

                axios.post('/api/updateProfile', {
                    name: this.name,
                    email: this.email,
                    phone: this.phone,
                    password: this.password,
                    confirmPassword: this.confirmPassword
                }, {
                    headers: {
                        'Authorization': 'Bearer ' + this.$store.state.token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then((response) => {
                    $('.spinner').remove();
                    $('.profile-update-btn').attr('disabled', false);
                    this.updateBtnText = "Update";

                    if (response.data.success) {
                        this.success = true;
                        this.successMsg = response.data.message;
                        
                        this.$store.commit('updateProfile', response.data);
                    } else {
                        this.error = true;
                        this.errorMsg = response.data.message;
                    }
                })
                .catch((errors) => {
                    if (errors.response.status == 401) {
                        this.$store.commit('CustomerLoggedOut');
                        this.$router.push('/home');
                    }

                    $('.spinner').remove();
                    $('.profile-update-btn').attr('disabled', false);
                    this.updateBtnText = "Update";

                    if (errors.response.status == 422) {
                        this.errors = errors.response.data.errors;
                    }
                });
            }
        },
        mounted() {
            this.$Progress.finish();
        },
        created() {
            this.$Progress.start();

            document.title = 'MyBlogs | Profile';

            localStorage.removeItem('articleUrl');
        }
    }
</script>
