const { createApp } = Vue;

createApp({
  data() {
    return {
      username: "",
      username_error: "",

      first_name: "",
      first_name_error: "",

      last_name: "",
      last_name_error: "",

      password: "",
      password_error: "",

      confirm_password: "",
      confirm_password_error: "",

      page_error_message: "",
      microsoft_id: "",
    };
  },
  methods: {
    signUp(e) {
      e.preventDefault();
      let data = new FormData(e.currentTarget);

      if (this.password != this.confirm_password) {
        this.confirm_password_error = "This must be the same with Password";
        return;
      }

      axios({
        url: "",
        method: "POST",
        data: data,
      })
        .then((response) => {
          console.log(response.data);
          window.location.href = "sign-up-success.html";
        })
        .catch((err) => {
          let error = err.response.data;
          if (error["code"] == 1) {
            document
              .querySelector("input[name='username']")
              .classList.add("error");
            this.username_error = error["description"];
          } else {
            alert(error["description"]);
          }
        });
    },
    logIn(e) {
      e.preventDefault();
      axios({
        url: "",
        method: "POST",
        data: new FormData(e.currentTarget),
      })
        .then((response) => {
          console.log(response.data);
          window.location.href = "/views";
        })
        .catch((err) => {
          let error = err.response.data;
          if (error["code"] == 1) {
            document
              .querySelector("input[name='username']")
              .classList.add("error");
            this.username_error = error["description"];
          } else if (error["code"] == 3) {
            document
              .querySelector("input[name='username']")
              .classList.add("error");
            document
              .querySelector("input[name='password']")
              .classList.add("error");
            this.page_error_message = error["description"];
          } else {
            alert(error["description"]);
          }
        });
    },

    checkMicrosoftId() {
      axios({
        url: "services/check-id.php",
        method: "POST",
        data: {
          "microsoft-id": this.microsoft_id,
        },
      })
        .then((response) => {
          return true;
        })
        .catch((error) => {
          return false;
        });
    },

    redirect(path) {
      window.location.href = path;
    },
    findGetParameter(parameterName) {
      var result = null,
        tmp = [];
      location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
          tmp = item.split("=");
          if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
      return result;
    },
    findHashParam(parameterName) {
      let hash = window.location.hash.replace("#", "");
      let params = new URLSearchParams(hash);
      let value = params.get(parameterName);
      return value ? value : null;
    },
  },
  watch: {
    confirm_password(new_data) {
      if (new_data != this.password) {
        document
          .querySelector("input[name='confirm_password']")
          .classList.add("error");
      } else {
        document
          .querySelector("input[name='confirm_password']")
          .classList.remove("error");
        this.confirm_password_error = "";
      }
    },

    username() {
      document
        .querySelector("input[name='username']")
        .classList.remove("error");
      this.username_error = "";
    },
    password() {
      document
        .querySelector("input[name='password']")
        .classList.remove("error");
      this.password_error = "";
    },
  },
  mounted() {
    const path = window.location.pathname;

    if (
      typeof social_details !== "undefined" &&
      Object.keys(social_details).length >= 1
    ) {
      if (social_details["error"] != "") {
        this.page_error_message = social_details["error"];
      } else {
        this.first_name = social_details["first_name"];
        this.last_name = social_details["last_name"];
        this.username = social_details["username"];
      }
    }

    if (
      this.findGetParameter("using") === "microsoft" &&
      !this.findGetParameter("error")
    ) {
      let microsoft_graph_url = "https://graph.microsoft.com/v1.0/me/";
      let microsoft_access_token = this.findHashParam("access_token");
      if (path == "/views/index.php" || path == "/views/") {
        if (microsoft_access_token) {
          axios({
            url: microsoft_graph_url,
            headers: {
              Authorization: "Bearer " + microsoft_access_token,
              "Content-Type": "application/json",
            },
          }).then((response) => {
            this.microsoft_id = response.data["id"];
            axios({
              url: "",
              method: "POST",
              data: {
                "microsoft-id": this.microsoft_id,
              },
            }).then((response) => {
              window.location.href = response.data.data.redirect;
            });
          });
        }
      } else {
        if (!microsoft_access_token) {
          window.location.href = "/views/";
        }

        axios({
          url: microsoft_graph_url,
          headers: {
            Authorization: "Bearer " + microsoft_access_token,
            "Content-Type": "application/json",
          },
        })
          .then((response) => {
            let microsoft_basic_data = response.data;
            this.first_name = microsoft_basic_data["givenName"];
            this.last_name = microsoft_basic_data["surname"];
            this.microsoft_id = microsoft_basic_data["id"];
            if (this.checkMicrosoftId()) {
              this.redirect("/views/sign-up.php?using=microsoft&error=1");
            }
          })
          .catch((error) => {
            alert(
              error.response.data["error"]["code"] +
                ":\n" +
                error.response.data["error"]["message"]
            );
            window.location.href = "/views/";
          });
      }
      history.replaceState(null, null, " ");
    } else {
      console.log(path);
    }
  },
}).mount("#app");
