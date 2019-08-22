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
                .then(function(response) {
                  return response;
                  
                })
                .catch(function(error) {
                  console.log(error);
                });
        }
    }
}