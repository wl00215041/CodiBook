<template>
    <div id="bootCentent">
        <div class="row">
            <div class="col-md-3">
                <mavon-editor :toolbarsFlag="false"
                              :language="language"
                              :subfield=false
                              :defaultOpen="'preview'"
                              :boxShadow=false
                              v-model="markdown"/>
            </div>

            <div class="col-md-9">
                <div v-if="isAuth" class="book-container embed-responsive embed-responsive-16by9">
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
            markdown: '',
            isAuth:false
        }
    },
    methods:{
        getBook(){
            axios.get('/book/' + this.$route.params.id).then(
                (res) => {
                    this.markdown = (res.data.markdown) ? res.data.markdown :　'';
                    this.isAuth = true;
                }
            ).catch((res)=>{
                this.markdown = 'Not Found or No Permission';
            })
        },
    },
    computed:{

    }
}
</script>

<style>

</style>