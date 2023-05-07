import axios from "axios";

axios.defaults.withCredentials = true;
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const buildRequestConfig = (accessToken) => ({
  headers: {
    "Content-type": "application/json",
    Authorization: `Bearer ${accessToken}`,
  },
});

const GetRequest = (url, accessToken = "") => {
  return axios.get(url, buildRequestConfig(accessToken)).catch((error) => {
    const status = error.response.status;
    let objResponse = {};
    objResponse = {
      data: {
        error: error.response.data,
      },
      status: status,
    };
    return objResponse;
  });
};

const PostWithoutTokenRequest = (url, data) => {
  return axios.post(url, data).catch((error) => {
    const status = error.response.status;
    let objResponse = {};
    objResponse = {
      data: {
        error: error.response.data,
      },
      status: status,
    };
    return objResponse;
  });
};

const PostRequest = (url, data, accessToken = "") => {
  return axios
    .post(url, data, buildRequestConfig(accessToken))
    .catch((error) => {
      const status = error.response.status;
      let objResponse = {};
      objResponse = {
        data: {
          error: error.response.data,
        },
        status: status,
      };
      return objResponse;
    });
};

const PostUploadRequest = (url, data, accessToken = "") => {
  return axios
    .post(url, data, {
      headers: {
        "Content-type": "multipart/form-data",
        Authorization: `Bearer ${accessToken}`,
      },
    })
    .catch((error) => {
      const status = error.response.status;
      let objResponse = {};
      objResponse = {
        data: {
          error: error.response.data,
        },
        status: status,
      };
      return objResponse;
    });
};

const PatchRequest = (url, data, accessToken = "") => {
  return axios
    .patch(url, data, buildRequestConfig(accessToken))
    .catch((error) => {
      const status = error.response.status;
      let objResponse = {};
      objResponse = {
        data: {
          error: error.response.data,
        },
        status: status,
      };
      return objResponse;
    });
};

const DeleteRequest = (url, accessToken = "") => {
  return axios.delete(url, buildRequestConfig(accessToken)).catch((error) => {
    const status = error.response.status;
    let objResponse = {};
    objResponse = {
      data: {
        error: error.response.data,
      },
      status: status,
    };
    return objResponse;
  });
};

const PutRequest = (url, data, accessToken = "") => {
  return axios
    .put(url, data, buildRequestConfig(accessToken))
    .catch((error) => {
      const status = error.response.status;
      let objResponse = {};
      objResponse = {
        data: {
          error: error.response.data,
        },
        status: status,
      };
      return objResponse;
    });
};

export {
  GetRequest,
  PostRequest,
  PatchRequest,
  PutRequest,
  DeleteRequest,
  PostWithoutTokenRequest,
  PostUploadRequest,
};
