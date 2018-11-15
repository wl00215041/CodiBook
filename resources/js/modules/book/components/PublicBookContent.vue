<template>
    <div v-if="isAuth" id="bootCentent">
        <div class="row">
            <div class="col-md-3 scrollbar embed-responsive embed-responsive-16by9" id="style-10">
                <div class="embed-responsive-item">
                    <div class="title">
                        <h1>{{ book.name }}</h1>
                    </div>
                    <mavon-editor :toolbarsFlag="false"
                                :language="language"
                                :subfield=false
                                :defaultOpen="'preview'"
                                :boxShadow=false
                                v-model="markdown"/>
                </div>
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
import Vue from 'vue'
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
            book: {},
            markdown: '',
            isAuth:false,
            language: 'en',
        }
    },
    methods:{
        getBook(){
            axios.get('/books/' + this.$route.params.id).then(
                (res) => {
                    this.book = res.data;
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
    .title {
        text-align: center;
        border: 1px solid #e0e0e0;
    }
.scrollbar
{
	float: left;
	overflow-y: scroll;
	margin-bottom: 25px;
}
#style-10::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
	border-radius: 10px;
}

#style-10::-webkit-scrollbar
{
	width: 10px;
	background-color: #F5F5F5;
}

#style-10::-webkit-scrollbar-thumb
{
	background-color: #AAA;
	border-radius: 10px;
	background-image: -webkit-linear-gradient(90deg,
	                                          rgba(0, 0, 0, .2) 25%,
											  transparent 25%,
											  transparent 50%,
											  rgba(0, 0, 0, .2) 50%,
											  rgba(0, 0, 0, .2) 75%,
											  transparent 75%,
											  transparent)
}
</style>