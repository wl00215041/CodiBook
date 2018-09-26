<template>

<div class="card text-white bg-secondary mb-3 shadow rounded" style="max-width: 18rem;">
  <div class="card-header"><router-link :to="{ name: 'book', params: {id: book.id } }">{{ book.name }}</router-link></div>
  <div class="card-body">
    <p class="card-text">{{ book.description }}</p>
  </div>
</div>
</template>

<script>
    export default({
        props: ['book']
    })
</script>

<style>
  .card{
    float:left;
    margin-right: 10px;
    margin-bottom: 10px;
  }
  a {
    color: white;
  }
</style>