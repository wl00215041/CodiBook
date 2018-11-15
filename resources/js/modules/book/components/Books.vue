<template>
<Row>
    <transition-group name="fadeLeft" tag="ul">
        <book-card v-for="(book, index) in books" :book="book" :key="index" @delete="onDeleteBook"></book-card>
    </transition-group>
    <alert-delete v-model="modal2" :objectName="selectedBook.name" @deleteConfirmed="deleteBook"></alert-delete>
</Row>
</template>

<script>
window.Vue = require('vue');
import BookCard from './widget/BookCard.vue'
import AlertDelete from '../../../components/widget/AlertDelete.vue'
import { mapState, mapActions } from 'vuex'

export default {
    components: {
        BookCard,
        AlertDelete
    },
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
        }
    },
    methods: {
        showTips(){
            if(this.books.length == 0){
                    this.$Notice.config({top:80});
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
        deleteBook (confirmed) {
            if(!confirmed)return;
            this.$store.dispatch('books/deleteBook', this.selectedBook.id).then(
                ()=> this.$Message.success('Successfully delete')
            ).catch(
                res => this.$Message.error('Error delete')
            );
            this.selectedBook = {};
            this.modal2 = false;
        }
    },
}
</script>
