<template>
<div>
    <book-card v-for="(book, index) in books" :book="book" :key="index"></book-card>
</div>
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
            books: ''
        }
    },
    methods: {
        getBooks(){
            axios.get('/books').then(
                (res)=>{
                    this.books = res.data;
                }
            );
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
