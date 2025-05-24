import { ref } from "vue";
import axios from "axios";

export const useLogin = () => {
  const url = ref("");
  const email = ref("");
  const password = ref("");

  const common = ref(undefined);

  const getLoginInfo = () => {
    return axios
      .get("/api/login_info")
      .then((authData) => {
        console.log("authData: " + JSON.stringify(authData));
        sessionStorage.setItem("authData", JSON.stringify(authData));
      })
      .catch((err: any) => {
        throw err;
      });
  };

  const login = () => {
    let authData = sessionStorage.getItem("authData");
    if (authData) {
      let parsedAuthData = JSON.parse(authData);
      parsedAuthData.data.username = email.value;
      parsedAuthData.data.password = password.value;
      return axios
        .post("/oauth/token", parsedAuthData.data, {
          headers: {
            "Content-Type": "application/json"
          }
        })
        .then((response) => {
          console.log(response.data);
        })
        .catch((error) => {
          console.error(error);
        });
    }
  };

  const loginCallback = (code: string) => {
    return axios
      .get("/api/login_callback_info")
      .then((res1) => {
        axios
          .post(
            `https://oauth2.googleapis.com/token?code=${code}&client_id=${res1.data.client_id}&client_secret=${res1.data.client_secret}&redirect_uri=${res1.data.redirect_uri}&grant_type=authorization_code`
          )
          .then((res2) => {
            axios.post("/api/login", { token: res2.data.access_token }).then((res3) => {
              console.log(res3);
              location.href = "/delivery_allocation/list";
            });
          });
      })
      .catch((err: any) => {
        throw err;
      })
      .finally(() => {});
  };

  return {
    url,
    email,
    password,
    common,
    getLoginInfo,
    login,
    loginCallback
  };
};
