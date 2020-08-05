<template>
    <div id="main-div">
        <!-- Page Header -->

        <header class="masthead" style="background-image: url('/img/bg-payment.jpg')">
        
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-10 mx-auto">
                        <div class="page-heading">
                            <h1>Payment</h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <p class="text-center">To access premium article, use have to subscribe to our services by making payment of Rs.99/year.</p>
                    <div id="payment-button" class="text-center"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import paypal from 'paypal-checkout';

    export default {
        data() {
            return {
                data: "",
                token: ""
            }
        },
        mounted() {
            this.$Progress.finish();

            let customer_id = this.$store.state.customer.id;
            let token = this.$store.state.token;
            paypal.Button.render({
                env: 'sandbox',
                client: {
                    sandbox: process.env.MIX_PAYPAL_CLIENT_ID
                },
                locale: 'en_US',
                style: {
                    size: 'large',
                    color: 'gold'
                },
                commit: true,
                payment: function(resolve, reject) {
                    return new Promise((resolve, reject) => {
                        axios.post('/api/payment/create', {                            
                            return_url: localStorage.getItem('articleUrl') == null ? process.env.MIX_APP_URL + '/home' : process.env.MIX_APP_URL + '/post/' + localStorage.getItem('articleUrl'),
                            cancel_url: process.env.MIX_APP_URL + '/payment',
                            amount: 99,
                            customer_id: customer_id
                        }, {
                            headers: {
                                Authorization: 'Bearer ' + token
                            }
                        })
                        .then((response) => {
                            resolve(response.data.id);
                        })
                        .catch((errors) => {
                            reject(errors.response);
                        });
                    })
                },
                onAuthorize: function (data, actions) {
                    return new Promise((resolve, reject) => {
                        axios.post('/api/payment/execute', {
                            payer_id: data.payerID,
                            payment_id: data.paymentID
                        }, {
                            headers: {
                                Authorization: 'Bearer ' + token
                            }
                        })
                        .then((response) => {
                            resolve(response);

                            actions.redirect();
                        })
                        .catch((errors) => {
                            reject(errors);
                        });
                    })
                },
                onCancel: function(data, actions) {
                    actions.redirect();
                }
            }, '#payment-button');

            $('html, body').animate({
                scrollTop: $('#main-div').offset().top - 100
            }, 1000);
        },
        created() {
            this.$Progress.start();

            document.title = 'MyBlogs | Payment';
        }
    }
</script>
