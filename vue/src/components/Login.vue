<template>
  <div>
    <h1 class="text-danger">Login view</h1>
    <router-link to="/">Home</router-link>
    <router-link to="/blog">Blog</router-link>
    <div class="container">
      <form @submit.prevent="loginHandler">
        <div class="row">
          <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
            <h1>Login</h1>
            <hr />
            <div class="form-group">
              <label for="username">Username</label>
              <input v-model="username" type="text" id="username" class="form-control" />
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input v-model="password" type="password" id="password" class="form-control" />
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <button class="btn btn-primary">Submit!</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { loginUser } from '@/services/authService'
export default {
  name: "Login",
  data() {
    return {
      username: "",
      password: ""
    };
  },
  mixins: [loginUser],

  methods: {
    loginHandler() {
      this.isSubmitted = true;
      this.login(this.username, this.password)
        .then(res => this.$router.push('/'))
    }

  }
};

/*
       this.axios.get("http://localhost:8000/test").then((response) => {
        console.log(response.data)
        
})
*/
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
