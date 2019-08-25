<template>
  <div class="index-content">
    <template v-if="!isAdmin">
      <div class="text-right mr-4">
        <button v-on:click="RemoveArticleHandler()" type="button" class="btn btn-danger mr-2">
                    Remove
                  </button>
        <router-link :to="'/edit-article-' + id" class="btn btn-outline-success">Edit Article</router-link>

      </div>
    </template>
    <div class="container">
      <h3>{{article.title}}</h3>
      <p class="text-right text-muted">Added on: {{article.dateAdded.date | formatDate}}</p>
      <h5 class="text-left text-muted">{{article.summary}}</h5>
      <p class="text-left mt-3">{{article.content}}</p>
    </div>
    <div class="col-md-6">
    <h5>Comments</h5>
    </div>
    <div class="row mx-auto mb-4 animated slideInUp" v-for="comment in comments" :key="comment.id">
      <div class="col-md-1">
        <div class="thumbnail">
          <img
            class="img-responsive user-photo"
            src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png"
          />
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <span class="mr-5">
              <strong>{{comment.username}}</strong>
            </span>
            <span class="text-muted pull-right">{{comment[0].dateAdded.date | formatDate}}</span>
          </div>
          <div class="panel-body text-left ml-3">{{comment[0].content}}</div>
          <!-- /panel-body -->
        </div>
      </div>
      <template v-if="!isAdmin">
      <div class="col-md-1 mt-3">
        <button v-on:click="RemoveCommentHandler(comment[0].id)" type="button" class="btn btn-danger btn-xs">
                    Remove
                  </button>
        </div>
      </template>
    </div>
    <template v-if="isAuthenticated">
      <form @submit.prevent="submitHandler">
        <div class="row">
          <div class="col-md-1"></div>
          <div class="form-group col-md-4 ml-2">
            <textarea v-model="newComment" id="newComment" class="form-control" placeholder="Add Comment..."></textarea>
            <div class="text-center text-danger"  
            v-if="!$v.newComment.minLength">
              <p>Comment must be at least 3 characters long!</p>
            </div>
            <div>
              <button class="btn btn-primary pull-right my-2">Submit</button>
            </div>
          </div>
        </div>
      </form>
    </template>
    <template v-else>
      <div class="row">
        <div class="col-md-1"></div>
        <div class="form-group col-md-4 ml-2">
          <p class="text-muted">
            To be able to comment, please
            <router-link to="/login">Login</router-link>
          </p>
        </div>
      </div>
    </template>
  </div>
</template>

<script>
import { viewArticle, deleteArticle } from "@/services/articleService";
import { deleteComment } from '@/services/commentService.js'
import { required, minLength } from "vuelidate/lib/validators";
export default {
  name: "Article",
  mixins: [viewArticle, deleteComment, deleteArticle],
  validations: {
      newComment: {
        required,
        minLength: minLength(3)
      }
  },
  methods: {
    submitHandler() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        this.$v.error=true;
        this.submitStatus = "ERROR";
      } else {
        this.$v.error=false;
        this.isSubmitted = true;
        this.addComment(this.newComment)
          // eslint-disable-next-line
          .then(response => {
            this.loadComments();
            this.newComment="";
          });
          
      }
    },
    RemoveCommentHandler(id) {
      this.removeComment(id).then(res => {
              this.loadComments();
          });
    },
    RemoveArticleHandler() {
      this.deleteArticle(this.$route.params.id)
      .then(this.$router.push('/blog'))
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.thumbnail {
  padding: 0px;
}
.card {
  position: relative;
}
.card > .card-header:after,
.card > .card-header:before {
  position: absolute;
  top: 11px;
  left: -16px;
  right: 100%;
  width: 0;
  height: 0;
  display: block;
  content: " ";
  border-color: transparent;
  border-style: solid solid outset;
  pointer-events: none;
}
.card > .card-header:after {
  border-width: 7px;
  border-right-color: #f7f7f7;
  margin-top: 1px;
  margin-left: 2px;
}
.card > .card-header:before {
  border-right-color: #ddd;
  border-width: 8px;
}
.panel-body {
    margin: 5px 5px 5px 5px;
}
.user-photo {
  max-width: 70px;
}
.index-content {
  margin-top: 50px;
}
</style>
