<template>
  <div id="app">
    <TableEmployes/>
  </div>
</template>

<script>
import TableEmployes from './components/TableEmployes'

export default {
  name: 'App',
  components: {
    TableEmployes
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
