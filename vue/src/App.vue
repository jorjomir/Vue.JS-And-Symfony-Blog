<template>
<div>
  <title>Georgi Sabev</title>
  <topnavbar></topnavbar>
  <div id="app">
    <transition name="page" mode="out-in">
    <router-view>
    <img alt="Vue logo" src="./assets/logo.png">
    <HelloWorld msg="Welcome to Your Vue.js App"/>
    </router-view>
    </transition>
  </div>
  <footerComponent></footerComponent>
</div>
</template>


<script>
import topnavbar from './components/TopNavbar'
import footerComponent from './components/Footer'
export default {
  name: 'app',
  components: {
    topnavbar,
    footerComponent
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
  
}
.page-enter-active, .page-leave-active {
  transition: opacity .3s, transform .3s;
}
.page-enter, .page-leave-to {
  opacity: 0;
  transform: translateY(-30%);
}

.router-anim-enter-active {
  animation: coming 1s;
  animation-delay: .4s;
  opacity: 0;
}
.router-anim-leave-active {
  animation: going 1s;
}
</style>
