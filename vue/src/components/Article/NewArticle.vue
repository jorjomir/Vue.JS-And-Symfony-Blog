<template>
  <div>
    <div class="container">
      <form @submit.prevent="createHandler">
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-10">
              <h3 class="mb-3">Create New Article</h3>
              <div class="form-group">
                <label for="title">Title</label>
                <input maxlength="60" v-model="title" type="text" id="title" class="form-control" />
              </div>
              <div class="form-group">
                <label for="summary">Summary</label>
                <input maxlength="160" v-model="summary" type="text" id="summary" class="form-control" />
              </div>
              <div class="form-group">
                <label for="content">Content</label>
                <textarea v-model="content" id="content" class="form-control" rows="10"></textarea>
              </div>
              <div>
                <button class="btn btn-primary pull-right my-2">Submit</button>
              </div>

              <div class="col-md-1"></div>
            
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { newArticle } from "@/services/articleService";
import { required, maxLength } from "vuelidate/lib/validators";
export default {
  name: "NewArticle",
  data() {
    return {
      title: "",
      summary: "",
      content: ""
    };
  },
  mixins: [newArticle],
  validations: {
    title: {
      required
    },
    summary: {
      required,
      maxLength: maxLength(5)
    },
    content: {
      required
    }
  },

  methods: {
    createHandler() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        this.submitStatus = "ERROR";
      } else {
        this.isSubmitted = true;
        this.createArticle(this.title, this.summary, this.content)
          // eslint-disable-next-line
          .then(response => {
              this.$router.push('article-' + response.data.id)
          });
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
