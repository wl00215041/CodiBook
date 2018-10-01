<template>

<div class="card bg-light mb-3" style="max-width: 18rem;">
  <div class="card-header">Create Book</div>
  <div class="card-body">
    <book-form :name="name" :description="description" @bookSubmit="submit"></book-form>
  </div>
</div>

</template>

<script>
    Vue.component('book-form', require('./BookForm.vue'));
    export default{
        data(){
            return {
                name: '',
                description: ''
            }
        },
        methods: {
            submit(card){
                axios.post('/books', {name: card.name, description: card.description}).then(
                    res => this.$router.push({ path: '/' })
                ).catch(
                    error => alert(error)
                )
            }
        }
    }
</script>