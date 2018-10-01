<template>
    <form>
        <p class="input-item">Book Name: <Input v-model="bookName" style="width: auto" placeholder="Input book name ..."  /></p>
        <p class="input-item">Description: <Input v-model="bookDescription" style="width: auto" placeholder="Input book description..." /></p>
        <Button type="success" :disabled="!bookName" @click.prevent="submit" long>SUBMIT</Button>
    </form>
</template>

<script>
export default {
    props: {
        'name': {
            type: String,
            default: ''
        }, 
        'description': {
            type: String,
            default: ''
        }
    },
    created(){
        this.bookName = this.name;
        this.bookDescription = this.description;
    },
    data(){
        return {
            bookName: '',
            bookDescription: ''
        }
    },
    methods: {
        submit(){
            this.$emit('bookSubmit', {'name': this.bookName, 'description': this.bookDescription});
        }
    }
}
</script>

<style>
    .input-item{
        margin-bottom:10px;
    }
</style>
