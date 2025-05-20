import axios from "axios";

export const useLogout = () => {
  const logout = () => {
    return axios.post("/api/logout").then((res) => {
      location.href = res.data.logout_url;
    });
  };

  return {
    logout
  };
};
