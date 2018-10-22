<template>
<Row>
    <mind-map-card v-for="(mindmap, index) in mindmaps" :mindmap="mindmap" :key="index" @delete="onDeleteMindMap"></mind-map-card>
    <Modal v-model="modal2" width="360">
        <p slot="header" style="color:#f60;text-align:center">
            <Icon type="ios-information-circle"></Icon>
            <span>Delete confirmation</span>
        </p>
        <div style="text-align:center">
            <p>Will you delete <Tag color="magenta">{{ selectedMindMap.name }}</Tag> ?</p>
            <p>Input MindMap name:<input type="text" v-model="deleteComfirmName"></p>
        </div>
        <div slot="footer">
            <Button type="error" size="large" long :loading="modal_loading" @click="deleteMindMap">Delete</Button>
        </div>
    </Modal>
</Row>
</template>

<script>
window.Vue = require('vue');
Vue.component('mind-map-card', require('./widget/MindMapCard.vue'));
import { mapState, mapActions } from 'vuex'

export default {
    mounted(){
        this.$store.dispatch('mindmaps/getList').then(() => this.showTips());
    },
    computed: mapState({
        mindmaps: state => state.mindmaps.all
    }),
    data(){
        return {
            modal2: false,
            modal_loading: false,
            selectedMindMap: {},
            deleteComfirmName: ''
        }
    },
    methods: {
        showTips(){
            if(this.mindmaps.length == 0){
                    this.$Notice.config({top:80});
                    this.$Notice.info({
                        title: 'Notification',
                        desc: 'Welcome to use CodiBook, Now you can add a new Book.'
                    });
            }
        },
        onDeleteMindMap(mindmap){
           this.modal2 = true;
           this.selectedMindMap = mindmap
        },
        deleteMindMap () {
            if(this.selectedMindMap.name != this.deleteComfirmName){
                this.$Message.warning('Incorrect comfirmation Name');
                return;
            }
            this.modal_loading = true;

            this.$store.dispatch('mindmaps/deleteMindMaps', this.selectedMindMap.id).then(
                ()=> this.$Message.success('Successfully delete')
            ).catch(
                res => this.$Message.error('Error delete')
            );


            this.selectedMindMap = {};
            this.deleteComfirmName = '';
            this.modal_loading = false;
            this.modal2 = false;
        },
    },
}
</script>
