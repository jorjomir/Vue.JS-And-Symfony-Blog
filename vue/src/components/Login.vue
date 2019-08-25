<template>
  <div>
    <div class="container">
      <form @submit.prevent="loginHandler">
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class="card">
              <h3 class="mb-3">Login</h3>
              <div class="text-center text-danger" v-if="$v.$error">
                <p>Invalid username or password!</p>
              </div>
              <div class="text-center text-danger" v-if="error">
                <p>Invalid username or password!</p>
              </div>
              <div class="form-group mx-3">
                <label for="username">Username</label>
                <input v-model="username" type="text" id="username" class="form-control" />
              </div>
              <div class="form-group mx-3">
                <label for="password">Password</label>
                <input v-model="password" type="password" id="password" class="form-control" />
              </div>
              <div>
                <button class="btn btn-primary pull-right my-2">Submit</button>
              </div>
            </div>
            <router-link to="/register">Register!</router-link>
          </div>

          <div class="col-md-3"></div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { loginUser } from "@/services/authService";
import { auth } from "@/services/authService";
import { required } from "vuelidate/lib/validators";
export default {
  name: "Login",
  data() {
    return {
      username: "",
      password: "",
      error: false
    };
  },
  mixins: [loginUser],
  validations: {
    username: {
      required
    }
  },

  methods: {
    loginHandler() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        this.submitStatus = "ERROR";
      } else {
        this.isSubmitted = true;
        this.login(this.username, this.password)
          // eslint-disable-next-line
          .then(user => {
            if (!this.isAuthenticated) {
              if (user.data.username == "jorjomir") {
                this.$root.$emit("logged", user.data.token);
                this.$root.$emit("logged-admin", user.data.username);
                this.$router.push("/");
              } else {
                this.$root.$emit("logged", user.data.token);
                this.$router.push("/");
              }
            }
          })
          .catch(
            setTimeout(() => {
              this.error = true;
            }, 1000)
          );
      }
      //this.error=true
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.container {
  margin-top: 60px;
}
</style>
