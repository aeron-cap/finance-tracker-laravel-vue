import Axios from "axios";

const axios = Axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL,
    withCredentials: true,
    withXSRFToken: true,
    headers: {
        Accept: "application/json",
        Authorization: `Bearer ${localStorage.getItem('token')}`,
    },
});

axios.interceptors.response.use(null, err => {
  const error = {
    status: err.response?.status,
    original: err,
    validation: {},
    message: null,
  };

  switch (err.response?.status) {
    case 422:
      for (let field in err.response.data.errors) {
        error.validation[field] = err.response.data.errors[field][0];
      }
      break;
    case 403:
      error.message = "You're not allowed to do that.";
      break;
    case 401:
      error.message = "Please re-login.";
      break;
    case 500:
      error.message = "Something went really bad. Sorry.";
      break;
  }

  return Promise.reject(error);
});

export default axios