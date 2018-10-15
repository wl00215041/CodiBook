<template>
    <div v-if="isAuth" id="bootCentent">
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
                <div class="book-container embed-responsive embed-responsive-16by9">
                <iframe ref="codimdIframe" class="embed-responsive-item" id="codimdIframe" name="codimdIframe" width="100%"  src="https://codimd.promise.com.tw"></iframe>
                </div>
            </div>
        </div>
    </div>    
</template>

<script>
window.Vue = require('vue');
import mavonEditor from 'mavon-editor'
import 'mavon-editor/dist/css/index.css'
Vue.use(mavonEditor);
export default{
    mounted(){
        this.getBook();
    },
    data(){
        return {
            markdown: '',
            isAuth:false,
            language: 'en',
        }
    },
    methods:{
        getBook(){
            axios.get('/books/' + this.$route.params.id).then(
                (res) => {
                    this.markdown = (res.data.markdown) ? res.data.markdown :　'';
                    this.isAuth = true;
                }
            ).catch(res=>{
                this.$Notice.error({
                    title: 'Notification',
                    desc: 'Not Found or No Permission '
                });
            })
        },
    },
    computed:{

    }
}
</script>

<style>

</style>