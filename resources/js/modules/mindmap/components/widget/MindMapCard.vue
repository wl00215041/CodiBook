<template>
    <Col span="4" class="card">
      <Card shadow>
          <p slot="title">
              <Icon type="ios-film-outline"></Icon>
              <router-link :to="{ name: 'mindmap', params: {id: mindmap.id } }">{{ mindmap.name }}</router-link>
          </p>
            <router-link slot="extra"  :to="{ name: 'mindmap', params: {id: mindmap.id } }">
             <Icon type="ios-brush" />
            </router-link>
          <a href="#" slot="extra" @click.prevent="deleteMindMap">
              <span> X</span>
          </a>
          <p class="card-text">{{ mindmap.description }}</p>
      </Card>
    </Col>
</template>

<script>
    export default({
        props: {
          'mindmap': Object
        },
        methods: {
          deleteMindMap(){
            this.$emit('delete', this.mindmap);
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