<template>
  <div>
    <div class="container">
      <form @submit.prevent="registerHandler">
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6 card">
            <h3 class="mb-3">Register</h3>
            <div class="text-center text-danger" v-if="!error">
              <p>This username already exists!</p>
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input
                @blur="usernameCheck"
                v-model="username"
                type="text"
                id="username"
                class="form-control"
              />
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input v-model="password" type="password" id="password" class="form-control" />
            </div>
            <div class="form-group">
              <label for="repeat-password">Repeat password</label>
              <input v-model="repeatPassword" @input="$v.repeatPassword.$touch()" type="password" id="repeatPassword" class="form-control" />
            </div>
            <div class="text-center text-danger"  
            v-if="!$v.repeatPassword.sameAsPassword">
              <p>Passwords don't match!</p>
            </div>
            <div>
              <button :disabled="!error || !$v.repeatPassword.sameAsPassword" class="btn btn-primary pull-right">Submit</button>
            </div>
          </div>
          <div class="col-md-3"></div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
//let error=true;
import { registerUser, checkUsername, loginUser } from "@/services/authService";
import { required, sameAs, minLength } from "vuelidate/lib/validators";
export default {
  name: "Register",
  data() {
    return {
      username: "",
      password: "",
      repeatPassword: "",
      error: true
    };
  },
  mixins: [registerUser, checkUsername, loginUser],
  validations: {
      username: {
          required
      },
      repeatPassword: {
          sameAsPassword: sameAs('password')
      }
  },

  methods: {
    registerHandler() {
      this.isSubmitted = true;

      this.register(this.username, this.password)
        // eslint-disable-next-line
        .then(
            this.login(this.username, this.password)
            .then(this.$router.push('/'))
        );
    },
    usernameCheck() {
      this.checkUsername(this.username)
        // eslint-disable-next-line
        .then(res => {
          if (res == "error") {
            this.error=false;
          } else {
              this.error=true;
          }
        });
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
