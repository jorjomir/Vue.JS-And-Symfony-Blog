<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
      <router-link to="/" class="navbar-brand">Georgi Sabev</router-link>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarResponsive"
        aria-controls="navbarResponsive"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <router-link to="/" class="nav-link">Home</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/blog" class="nav-link">Blog</router-link>
          </li>
          <template v-if="!isAuthenticated">
          <li class="nav-item">
            <router-link to="/login" class="nav-link">Login</router-link>
          </li>
          </template>
          <template v-else>
            <li class="nav-item">
            <a href="#" @click="Logout()" class="nav-link">Logout</a>
            </li>
          </template>
          <template v-if="!isAdmin">
            <li class="nav-item">
            <router-link to="/new-article" class="nav-link">+New Article</router-link>
            </li>
            <li class="nav-item">
            <router-link to="/comments" class="nav-link">Comments</router-link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: "TopNavbar",
  methods: {
    Logout() {
      this.$root.$emit('logged-out')
      this.$root.$emit('logged-out-admin')
      localStorage.clear();
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.navbar {
  z-index: 999999;
  margin-bottom: 0!important;
}
.navbar-brand {
  cursor: pointer;
}
</style>
