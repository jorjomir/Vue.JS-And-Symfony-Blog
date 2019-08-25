export const allComments = {
    data() {
      return {
        comments: []
      }
    },
    created() {
      this.loadComments();
    },
    methods: {
        removeComment(id) {
            return this.$http
              .post("/delete-comment", {
                id: id,
              })
              .then(function (response) {
                return response;
              })
              .catch(function (error) {
                // eslint-disable-next-line
                console.log(error);
              });
          },
        loadComments() {
            this.$http
            .get("/get-all-comments")
            .then(response => {
              this.comments = response.data[0];
            })
        }
        
    }
  }

  export const deleteComment = {
    methods: {
        removeComment(id) {
            return this.$http
              .post("/delete-comment", {
                id: id,
              })
              .then(function (response) {
                return response;
              })
              .catch(function (error) {
                // eslint-disable-next-line
                console.log(error);
              });
          }
        
    }
  }