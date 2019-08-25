<template>
  <div class="row">
    <div class="panel mx-auto panel-default widget">
      <div class="panel-heading mb-2">
        <h3 class="panel-title">Recent Comments</h3>
      </div>
      <div class="panel-body">
        <ul class="list-group">
          <li class="list-group-item" v-for="comment in comments" :key="comment[0].id">
            <div class="row">
              <div class="col-xs-10">
                <div>
                  <router-link :to="'/article-' + comment.id"
                  ><h5>{{comment.title}}</h5></router-link>
                  <div class="mic-info">
                    By:
                    <a href="#">{{comment.username}}</a>
                    on {{comment[0].dateAdded.date | formatDate}}
                  </div>
                </div>
                <div class="comment-text">{{comment[0].content}}</div>
                <div class="action">
                  <button v-on:click="RemoveCommentHandler(comment[0].id)" type="button" class="btn btn-danger btn-xs">
                    Remove
                  </button>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import { allComments, deleteComment } from '@/services/commentService.js'
export default {
  name: "Comments",
  mixins: [allComments, deleteComment],
  methods: {
      RemoveCommentHandler(id) {
          this.removeComment(id).then(res => {
              this.loadComments();
          });
      }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.widget .panel-body {
  padding: 0px;
}
.widget .list-group {
  margin-bottom: 0;
}
.widget .panel-title {
  display: inline;
}
.widget .label-info {
  float: right;
}
.widget li.list-group-item {
  border-radius: 0;
  border: 0;
  border-top: 1px solid #ddd;
}
.widget li.list-group-item:hover {
  background-color: rgba(86, 61, 124, 0.1);
}
.widget .mic-info {
  color: #666666;
  font-size: 15px;
}
.widget .action {
  margin-top: 5px;
}
.widget .comment-text {
  font-size: 15px;
}
.widget .btn-block {
  border-top-left-radius: 0px;
  border-top-right-radius: 0px;
}
.row {
  margin-top: 40px;
    margin-right: unset;
    margin-left: unset;
}
.col-xs-10 {
    width: 100%;
}
</style>
