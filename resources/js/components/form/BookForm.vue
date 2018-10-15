<template>
    <form>
        <p class="input-item">
            Book Name: <Input v-model="bookName" style="width: auto" placeholder="Input book name ..."  />
        </p>
        <p class="input-item">
            Description: <Input v-model="bookDescription" style="width: auto" placeholder="Input book description..." />
        </p>
        <p class="input-item">
            Type: <Select v-model="bookType" style="width:200px">
                <Option v-for="(item) in BOOT_TYPES" :value="item.name" :key="item.id">{{ item.name }}</Option>
            </Select>
        </p>
        <br><br>
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
        },
        'type': {
            type: String,
            default: 'Book'
        }
    },
    created(){
        this.bookName = this.name;
        this.bookDescription = this.description;
        this.bookType = this.type;
    },
    data(){
        return {
            BOOT_TYPES: [
                {id:1, "name": 'Book'},
                {id:2, "name": 'MindMap'}
            ],
            bookName: '',
            bookDescription: '',
            bookType: '',
        }
    },
    methods: {
        submit(){
            this.$emit('bookSubmit', {'name': this.bookName, 
                                      'description': this.bookDescription,
                                      'type': this.bookType
                                     });
        }
    }
}
</script>

<style>
    .input-item{
        margin-bottom:10px;
    }
</style>
