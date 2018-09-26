<template>
    <div id="bootCentent">
        <div class="row">
                <div class="col-md-3 embed-responsive embed-responsive-16by9">
                    <div class="scoll embed-responsive-item">
                        <b-button @click="switchEditable">{{ (editable) ? 'Editing' : 'Edit' }}</b-button>
                        <b-dropdown id="ddown-header" :text="(isPublic) ? 'Public' : 'Private'" class="m-2" style="z-index: 1501;">
                            <b-dropdown-item-button @click="setPublic(true)">Public</b-dropdown-item-button>
                            <b-dropdown-item-button @click="setPublic(false)">Private</b-dropdown-item-button>
                        </b-dropdown>
                        <a v-if="isPublic" class="btn" :href="publicLink" target="_blank">Public Link</a>
                        
                        <mavon-editor :toolbarsFlag="false"
                                    :language="language"
                                    :subfield=false
                                    :defaultOpen="'preview'"
                                    :boxShadow=false
                                    v-model="markdown"/>
                    </div>
            </div>

            <div class="col-md-9">
                <b-alert :show="dismissCountDown"
                        dismissible
                        fade
                        @dismissed="dismissCountDown=0"
                        @dismiss-count-down="countDownChanged">
                Update successful {{dismissCountDown}} seconds...
                </b-alert>
                <mavon-editor @save="updateMarkdown" 
                              v-if="editable" 
                              :language="language" 
                              :defaultOpen="'edit'"
                              v-model="markdown"/>
                <div v-show="!editable" class="book-container embed-responsive embed-responsive-16by9">
                <iframe ref="codimdIframe" class="embed-responsive-item" id="iframe" name="iframe1" width="100%"  src="https://codimd.promise.com.tw"></iframe>
                </div>
            </div>
        </div>
    </div>    
</template>

<script>
window.Vue = require('vue');
import mavonEditor from 'mavon-editor'
import BootstrapVue from 'bootstrap-vue';
import 'mavon-editor/dist/css/index.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.use(mavonEditor);
Vue.use(BootstrapVue);
export default{
    mounted(){
        this.getBook();
       // axios.get('https://codimd.promise.com.tw/history').then(function(res){
      //      console.log(res);
       // });
    },
    data(){
        return {
            editable: false,
            isPublic: false,
            language: 'en',
            markdown: '',
            dismissSecs: 5,
            dismissCountDown: 0,
            showDismissibleAlert: false,
        }
    },
    methods:{
        getBook(){
            axios.get('/book/' + this.$route.params.id).then(
                (res) => {
                    this.markdown = (res.data.markdown) ? res.data.markdown :　'';
                    console.log(res.data);
                    this.isPublic = res.data.is_public;
                }
            ).catch((res)=>{
                this.markdown = 'Not Found or No Permission';
            })
        },
        setPublic(isPublic){
            axios.put('/book/'+ this.$route.params.id, {isPublic: isPublic ? 'public' : 'private'}).then(
                (res) => {
                    this.isPublic = isPublic;
                    this.showAlert()
                }
            )            
        },
        switchEditable () {this.editable = !this.editable},
        updateMarkdown(){
            axios.put('/book/'+ this.$route.params.id, {markdown: this.markdown}).then(
                (res) => this.showAlert()
            )
        },
        countDownChanged (dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        showAlert () {
            this.dismissCountDown = this.dismissSecs
        }
    },
    computed:{
        publicLink(){
            return "/public#/public/book/" + this.$route.params.id;
        }
    }
}
</script>

<style>
.scoll {
    overflow-y:scroll
}
</style>