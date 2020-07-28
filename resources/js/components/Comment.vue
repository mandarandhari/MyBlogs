<template>
    <div class="col-md-12 mb-5">
        <div class="row">
            <div class="col-md-6 float-left">
                <h4 class="font-weight-bold">{{ customername }}</h4>
            </div>
            <div class="col-md-6">
                <i class="float-right" style="font-size: 17px;">commented on {{ createdat | dateFormat }}</i>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-2">
                <span style="font-size: 18px;">{{ comment }}</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['customername', 'createdat', 'comment']
    }
</script>
