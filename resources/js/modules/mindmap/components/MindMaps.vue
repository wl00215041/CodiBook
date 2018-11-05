<template>
<Row>
    <mind-map-card v-for="(mindmap, index) in mindmaps" :mindmap="mindmap" :key="index" @delete="onDeleteMindMap"></mind-map-card>
    <alert-delete v-model="modal2" :objectName="selectedMindMap.name" @deleteConfirmed="deleteMindMap"></alert-delete>
</Row>
</template>

<script>
window.Vue = require('vue');
import { mapState, mapActions } from 'vuex'
import AlertDelete from '../../../components/widget/AlertDelete.vue'
import MindMapCard from './widget/MindMapCard.vue'

export default {
    components: {
        AlertDelete,
        MindMapCard
    },
    mounted(){
        this.$store.dispatch('mindmaps/getList').then(() => this.showTips());
    },
    computed: mapState({
        mindmaps: state => state.mindmaps.all
    }),
    data(){
        return {
            modal2: false,
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
        deleteMindMap (confirmed) {
            if(!confirmed)return;
            this.$store.dispatch('mindmaps/deleteMindMaps', this.selectedMindMap.id).then(
                ()=> this.$Message.success('Successfully delete')
            ).catch(
                res => this.$Message.error('Error delete')
            );
            this.selectedMindMap = {};
            this.modal2 = false;
        },
    },
}
</script>
