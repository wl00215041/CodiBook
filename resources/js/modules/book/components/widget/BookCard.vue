<template>
    <Col span="4" class="card">
      <Card shadow>
          <p slot="title">
              <Icon type="ios-film-outline"></Icon>
              <router-link :to="{ name: 'book', params: {id: book.id } }">{{ book.name }}</router-link>
          </p>
            <router-link slot="extra"  :to="{ name: 'bookEdit', params: {id: book.id } }">
             <Icon type="ios-brush" />
            </router-link>
          <a href="#" slot="extra" @click.prevent="deleteBook">
              <span> X</span>
          </a>
          <p class="card-text">{{ book.description }}</p>
      </Card>
    </Col>
</template>

<script>
    export default({
        props: {
          /**
           * Book object
           */
          'book': {
            type: Object,
            required: true
          }
        },
        methods: {
         /** Create delete event when user click X
         * @event delete
         * @type {book}
         */
          deleteBook(){
            this.$emit('delete', this.book);
          }
        }
    })
</script>

<style>
.card {
  margin-left: 10px;
  margin-bottom: 10px;
}
</style>