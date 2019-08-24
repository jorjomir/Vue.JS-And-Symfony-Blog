<template>
  <div>
    <div class="container">
      <form @submit.prevent="editHandler">
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-10">
              <h3 class="mb-3">Edit Article</h3>
              <div class="form-group">
                <label for="title">Title</label>
                <input maxlength="60" v-model="article.title" type="text" id="title" class="form-control" />
              </div>
              <div class="form-group">
                <label for="summary">Summary</label>
                <input maxlength="160" v-model="article.summary" type="text" id="summary" class="form-control" />
              </div>
              <div class="form-group">
                <label for="content">Content</label>
                <textarea v-model="article.content" id="content" class="form-control" rows="10"></textarea>
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
import { editArticleService } from "@/services/articleService";
export default {
  name: "EditArticle",
  mixins: [editArticleService],

  methods: {
    editHandler() {
        this.editArticle(this.article.title, this.article.summary, this.article.content)
        .then(res => this.$router.push('article-' + res.data.id))
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
