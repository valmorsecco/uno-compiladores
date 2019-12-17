const config = {
  api: {
    url: "http://localhost"
  },
  timezone: "America/Sao_Paulo",
  version: "1.0.0"
};

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.crossDomain = true;
