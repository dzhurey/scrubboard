$.ajaxSetup({
  beforeSend: (xhr) => {
    const token = localStorage.token;
    xhr.setRequestHeader('Authorization', token);
    xhr.setRequestHeader('accept', 'application/json');
  },
  error: (xhr, textStatus, error) => {
    const errorMsg = xhr.responseJSON.message;
    const invalidCsrf = errorMsg.search("Invalid CSRF") >= 0;
    if (invalidCsrf) window.location.replace('/');
  }
});

export default {

  download: (url) => {
    return $.ajax({
      beforeSend: (xhr) => {
        const token = localStorage.token;
        xhr.setRequestHeader('Authorization', token);
        xhr.setRequestHeader('accept', 'application/pdf');
      },
      xhrFields: {
        responseType: 'blob'
      },
      type: 'GET',
      url: url,
    });
  },

  get: (url) => {
    return $.ajax({
      type: 'GET',
      url: url,
      contentType: 'application/json',
    });
  },

  post: (url, data) => {
    return $.ajax({
      type: 'POST',
      url: url,
      contentType: 'application/json',
      data: JSON.stringify(data),
    });
  },

  put: (url, data) => {
    return $.ajax({
      type: 'PUT',
      url: url,
      contentType: 'application/json',
      data: JSON.stringify(data),
    });
  },

  delete: (url, data) => {
    return $.ajax({
      type: 'DELETE',
      url: url
    })
  }
};
