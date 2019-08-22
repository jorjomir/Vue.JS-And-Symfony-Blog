<template>
<div>
  <topnavbar></topnavbar>
  <div id="app">
    <router-view>
    <img alt="Vue logo" src="./assets/logo.png">
    <HelloWorld msg="Welcome to Your Vue.js App"/>
    </router-view>
  </div>
</div>
</template>


<script>
import topnavbar from './components/TopNavbar'
export default {
  name: 'app',
  components: {
    topnavbar
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
