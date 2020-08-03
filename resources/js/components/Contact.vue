<template>
    <div>
        <!-- Page Header -->

        <header class="masthead" style="background-image: url('/img/bg-contact.jpg')">
        
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-10 mx-auto">
                        <div class="page-heading">
                            <h1>Contact Me</h1>
                            
                            <span class="subheading">Have questions? I have answers.</span>
                            
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">

                    <p>Want to get in touch? Fill out the form below to send me a message and I will get back to you as soon as possible!</p>
                    <form name="sentMessage" id="contactForm" novalidate @submit.prevent="addContact">
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
                            <div class="form-group floating-label-form-group controls">
                                <label>Message</label>
                                <textarea rows="5" class="form-control" placeholder="Message" id="message" v-model="message" required></textarea>
                                <p class="help-block text-danger" v-if="errors.message">{{ errors.message[0] }}</p>
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
                            <button type="submit" class="btn btn-primary send-message" id="sendMessageButton">{{ contactBtnText }}</button>
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
                name: '',
                email: '',
                phone: '',
                message: '',
                success: false,
                error: false,
                successMsg: '',
                errorMsg: '',
                errors: {},
                contactBtnText: "Send"
            }
        },
        methods: {
            addContact() {
                var spinner = document.createElement('i');
                spinner.className = 'fa fa-spinner fa-spin spinner';
                this.contactBtnText = ' Loading';
                $('.send-message').prepend(spinner);
                $('.send-message').attr('disabled', 'disabled');

                axios.post('/api/addContact', {
                    name: this.name,
                    email: this.email,
                    phone: this.phone,
                    message: this.message
                })
                .then((response) => {
                    this.success = false;
                    this.error = false;

                    $('.spinner').remove();
                    $('.send-message').attr('disabled', false);
                    this.contactBtnText = "Send";

                    if (response.data.success) {
                        this.success = true;
                        this.successMsg = response.data.message;
                        this.name = '';
                        this.email = '';
                        this.phone = '';
                        this.message = '';
                    } else {
                        this.error = true;
                        this.errorMsg = response.data.message;
                    }
                })
                .catch((errors) => {
                    $('.spinner').remove();
                    $('.send-message').attr('disabled', false);
                    this.contactBtnText = "Send";
                    
                    this.errors = errors.response.data.errors;
                });
            }
        },
        mounted() {
            this.$Progress.finish();
        },
        created() {
            this.$Progress.start();

            document.title = 'MyBlogs | Contact us';

            localStorage.removeItem('articleUrl');
        }
    }
</script>
