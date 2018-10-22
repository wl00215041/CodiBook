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
import { mapState, mapActions } from 'vuex'

export default {
    mounted(){
        this.$store.dispatch('books/getList').then(() => this.showTips());
    },
    computed: mapState({
        books: state => state.books.all
    }),
    data(){
        return {
            modal2: false,
            modal_loading: false,
            selectedBook: {},
            deleteComfirmName: ''
        }
    },
    methods: {
        showTips(){
            if(this.books.length == 0){
                    this.$Notice.info({
                        title: 'Notification',
                        desc: 'Welcome to use CodiBook, Now you can add a new Book.'
                    });
            }
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

            this.$store.dispatch('books/deleteBook', this.selectedBook.id).then(
                ()=> this.$Message.success('Successfully delete')
            ).catch(
                res => this.$Message.error('Error delete')
            );

            this.selectedBook = {};
            this.deleteComfirmName = '';
            this.modal_loading = false;
            this.modal2 = false;
        }
    },
}
</script>
