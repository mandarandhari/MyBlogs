<template>
    <div class="col-md-12 mb-5">
        <div class="row">
            <div class="col-md-6 float-left">
                <h4 class="font-weight-bold">{{ customername }}</h4>
            </div>
            <div class="col-md-6">
                <div class="float-right" v-if="customerid == $store.state.customer.id">
                    <md-button class="md-icon-button dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="outline: none;">
                        <i class="fas fa-ellipsis-v"></i>
                    </md-button>
                    <ul class="dropdown-menu arrow_box" style="padding: 0;">
                        <li>
                            <md-button style="width: 100%; margin: 0; color: #448aff;" @click.prevent="editBtnClicked">
                                <strong>
                                    <i class="fa fa-edit hover-btn" ></i>&nbsp;Edit
                                </strong>
                            </md-button>
                        </li>
                        <li>
                            <md-button style="width: 100%; margin: 0; color: #ff5252;" @click.prevent="deleteBtnClicked">
                                <strong>
                                    <i class="fa fa-trash hover-btn"></i>&nbsp;Delete
                                </strong>
                            </md-button>
                        </li>
                    </ul>
                </div>
                
                <i class="float-right" style="font-size: 17px; margin-top: 5px;">commented on {{ createdat | dateFormat }}</i>
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
    import VueMaterial from 'vue-material';
    Vue.use(VueMaterial);
    
    export default {
        props: ['customername', 'createdat', 'comment', 'customerid', 'editcomment', 'deletecomment'],
        methods: {
            editBtnClicked() {
                this.$emit('editcomment');
            },
            deleteBtnClicked() {
                this.$emit('deletecomment');
            }
        }
    }
</script>
