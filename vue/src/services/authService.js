export const auth= {
    computed: {
        isAuthenticated() {
            return localStorage.getItem('token') !== null;
        }
    }
}
//TODO: FOR LOGOUT JUST DELETE LOCALSTORAGE TOKEN AND USERNAME
export const loginUser = {
    methods: {
        login(username, password) {
            let options = {
                methods: "POST",
                header: {
                  "Content-Type": "application/json"
                }
              };
        
              return this.$http
                .post("/login", {
                  username: username,
                  password: password
                })
                .then(function(response) {
                
                    //LOGIN
                  if(response.data.username && response.data.token) {
                    localStorage.setItem('username', response.data.username);
                    localStorage.setItem('token', response.data.token)
                  }
                  
                })
                .catch(function(error) {
                  console.log(error);
                });
        }
    }
}
export const registerUser = {
  methods: {
      register(username, password) {
          let options = {
              methods: "POST",
              header: {
                "Content-Type": "application/json"
              }
            };
      
            return this.$http
              .post("/register", {
                username: username,
                password: password
              })
              .then(function(response) {
                console.log(response);
              })
              .catch(function(error) {
                console.log(error);
              });
      }
  }
}
export const checkUsername = {
  methods: {
      checkUsername(username) {
          let options = {
              methods: "POST",
              header: {
                "Content-Type": "application/json"
              }
            };
      
            return this.$http
              .post("/if-username-exists", {
                username: username,
              })
              .then(function(response) {
                if(response.data.status) {
                  return "error";
                }
              })
              .catch(function(error) {
                console.log(error);
              });
      }
  }
}