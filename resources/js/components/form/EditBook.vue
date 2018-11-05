<template>

<div class="card bg-light mb-3" style="max-width: 18rem;">
  <div class="card-header">Edit Book</div>
  <div class="card-body">
    <book-form v-for="(book, idx) in books" :key="idx" :name="book.name" :description="book.description" @bookSubmit="submit"></book-form>
  </div>
</div>

</template>

<script>
    Vue.component('book-form', require('./BookForm.vue'));
    export default{
        created(){
            this.getBook();
        },
        data(){
            return {
                books: []
            }
        },
        methods: {
            getBook(){
                axios.get('/books/' + this.$route.params.id)
                    .then(book => this.books.push(book.data))
                    .catch(res=>this.markdown = 'Not Found or No Permission')
            },
            submit(card) {
                let submitData = {
                    data: {
                        name: card.name, 
                        description: card.description
                    }
                }
                axios.put('/books/' + this.$route.params.id, submitData)
                  .then(res => this.$router.push({ path: '/' }))
                  .catch(error => alert(error))
            }
        }
    }
</script>