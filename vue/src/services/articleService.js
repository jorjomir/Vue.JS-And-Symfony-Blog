export const newArticle = {
  methods: {
    createArticle(title, summary, content) {
      let options = {
        methods: "POST",
        header: {
          "Content-Type": "application/json"
        }
      };

      return this.$http
        .post("/new-article", {
          title: title,
          summary: summary,
          content: content
        })
        .then(function (response) {
          return response;

        })
        .catch(function (error) {
          console.log(error);
        });
    }
  }
}

export const viewArticle = {
  data() {
    return {
      article: [],
      id: this.$route.params.id,
      comments: [],
      newComment: ""

    }
  },
  created() {
    this.loadArticle();
    this.loadComments();
      
  },
  methods: {
    addComment(content) {
      return this.$http
        .post("/add-comment", {
          id: this.$route.params.id,
          content: content,
          author: localStorage.getItem('username')
        })
        .then(function (response) {
          return response;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    loadArticle() {
      this.$http
      .post("/article", {
        id: this.$route.params.id,
      })
      .then(response => {
        if (response.data.error) {
          this.$router.push('/');
        } else {
          this.article = response.data
        }

      })
    },
    loadComments() {
      this.$http
      .post("/get-article-comments", {
        id: this.$route.params.id,
      })
      .then(response => {
        if (response.data.error) {
          this.$router.push('/');
        } else {
          this.comments = response.data[0];
        }

      })
    }
  }
}

export const allArticles = {
  data() {
    return {
      articles: []
    }
  },
  created() {
    this.$http
      .get("/all-articles")
      .then(response => {
        this.articles = response.data[0]
      })
  }
}

export const editArticleService = {
  data() {
    return {
      article: [],
      id: this.$route.params.id,
    }
  },
  created() {
    this.$http
      .post("/article", {
        id: this.$route.params.id,
      })
      .then(response => {
        if (response.data.error) {
          this.$router.push('/');
        } else {
          this.article = response.data
        }

      })
  },
  methods: {
    editArticle(title, summary, content) {
      let options = {
        methods: "POST",
        header: {
          "Content-Type": "application/json"
        }
      };

      return this.$http
        .post("/edit-article", {
          id: this.$route.params.id,
          title: title,
          summary: summary,
          content: content
        })
        .then(function (response) {
          return response;
        })
        .catch(function (error) {
          console.log(error);
        });
    }
  }
}

export const deleteArticle = {
  methods: {
      deleteArticle(id) {
          return this.$http
            .post("/delete-article", {
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