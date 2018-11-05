<template>
    <Modal v-model="isShow" width="360">
        <p slot="header" style="color:#f60;text-align:center">
            <Icon type="ios-information-circle"></Icon>
            <span>Delete confirmation</span>
        </p>
        <div style="text-align:center">
            <p>Will you delete <Tag color="magenta">{{ objectName }}</Tag> ?</p>
            <p>Input Book name:<input type="text" v-model="deleteComfirmName"></p>
        </div>
        <div slot="footer">
            <Button type="error" size="large" long @click="deleteObject">Delete</Button>
        </div>
    </Modal>
</template>

<script>
    export default{
        props: {
            value: {
                type: Boolean,
                default: false
            },
            objectName: {
                type: String,
                default: ''
            }
        },
        data(){
            return {
                deleteComfirmName: ''
            }
        },
        methods: {
            deleteObject(){
                if(this.isConfirmed) {
                    this.$emit('deleteConfirmed', true);
                }else{
                    this.$emit('deleteConfirmed', false);
                    this.$Message.warning('Incorrect comfirmation Name')
                };
                this.deleteComfirmName = ''
            },

        },
        computed: {
            isConfirmed(){
                return this.objectName === this.deleteComfirmName;
            },
            isShow: {
                get(){
                    return this.value;
                },
                set(value){
                    this.$emit('input', value);
                }
            }
        },
    }
</script>