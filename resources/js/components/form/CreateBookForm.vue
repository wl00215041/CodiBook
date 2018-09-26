<template>

<div class="card bg-light mb-3" style="max-width: 18rem;">
  <div class="card-header">Create Book</div>
  <div class="card-body">
    <form>
        <p>Book Name: <input type="text" v-model="bookName"></p>
        <p>Description: <input type="text" v-model="description"></p>

        <button :disabled="!bookName" @click.prevent="submit">Submit</button>
    </form>
  </div>
</div>

</template>

<script>
    export default{
        data(){
            return {
                bookName: '',
                'description': ''
            }
        },
        methods: {
            submit(){
                console.log("Submited");
                axios.post('/books', {name: this.bookName, description: this.description}).then(
                    (res)=>{
                        this.$router.push({ path: '/' })
                    }
                ).catch(
                    function(error){
                        alert(error);
                    }
                )
                
            }
        }
    }
</script>