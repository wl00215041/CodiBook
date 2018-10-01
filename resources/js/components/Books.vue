<template>
<Row>
    <book-card v-for="(book, index) in books" :book="book" :key="index" @delete="onDeleteBook"></book-card>
    <Modal v-model="modal2" width="360">
        <p slot="header" style="color:#f60;text-align:center">
            <Icon type="ios-information-circle"></Icon>
            <span>Delete confirmation</span>
        </p>
        <div style="text-align:center">
            <p>Will you delete <Tag color="magenta">{{ selectedBook.name }}</Tag> ?</p>
            <p>Input Book name:<input type="text" v-model="deleteComfirmName"></p>
        </div>
        <div slot="footer">
            <Button type="error" size="large" long :loading="modal_loading" @click="deleteBook">Delete</Button>
        </div>
    </Modal>
</Row>
</template>

<script>
window.Vue = require('vue');
Vue.component('book-card', require('./widget/BookCard.vue'));
let books = [];
export default {
    mounted(){
        this.getBooks();
    },
    data(){
        return {
            books: '',
            modal2: false,
            modal_loading: false,
            selectedBook: {},
            deleteComfirmName: ''
        }
    },
    methods: {
        getBooks(){
            axios.get('/books').then(
                (res)=>{
                    this.books = res.data;
                }
            ).finally(()=>{
                if(this.books.length == 0){
                    this.$Notice.info({
                        title: 'Notification',
                        desc: 'Welcome to use CodiBook, Now you can add a new Book.'
                    });
                }

            }
                
            );
        },
        onDeleteBook(book){
           this.modal2 = true;
           this.selectedBook = book
        },
        deleteBook () {
            if(this.selectedBook.name != this.deleteComfirmName){
                this.$Message.warning('Incorrect comfirmation Name');
                return;
            }
            this.modal_loading = true;
            axios.delete('/book/' + this.selectedBook.id).then(
                (res)=>{
                    this.$Message.success('Successfully delete');
                    this.getBooks();
                }
            ).catch(res => {
                    this.$Message.error('Error delete');
            })
            this.selectedBook = {};
            this.deleteComfirmName = '';
            this.modal_loading = false;
            this.modal2 = false;
        }
    },
    computed:{
        noteRoot(){
            let root = [];
            this.notes.forEach(element =>{
                if (!element.note_id) root.push(element);
            });
            return root;
        },
    }
}
</script>
