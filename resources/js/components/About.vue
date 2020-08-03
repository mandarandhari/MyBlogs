<template>
    <div>
        <!-- Page Header -->

        <header class="masthead" style="background-image: url('/img/bg-about.jpg')">
        
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-10 mx-auto">
                        <div class="page-heading">
                            <h1>About Me</h1>
                            
                            <span class="subheading">This is what I do.</span>
                            
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed quisquam ut perspiciatis, repudiandae nulla animi iste vel, praesentium repellendus molestias aliquid consequatur, earum rem qui error voluptates eius enim consequuntur!</p>

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex alias, earum consectetur quia natus ducimus voluptate explicabo, hic porro reprehenderit, quasi? Tenetur ipsum distinctio laboriosam perspiciatis officiis dolore, architecto id.</p>

                    <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Totam inventore aspernatur repellendus incidunt adipisci modi voluptates recusandae iste eligendi, repudiandae corporis quod aut, optio! Explicabo quaerat unde voluptatem! Itaque, eum!</p>


                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        mounted() {
            this.$Progress.finish();
        },
        created() {
            this.$Progress.start();

            document.title = 'MyBlogs | About';

            localStorage.removeItem('articleUrl');
        }
    }
</script>
