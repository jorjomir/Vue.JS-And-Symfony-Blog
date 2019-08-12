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
                  localStorage.setItem('username', response.data.username);
                  localStorage.setItem('token', response.data.token)
                })
                .catch(function(error) {
                  console.log(error);
                });
        }
    }
}