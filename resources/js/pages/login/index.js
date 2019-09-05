import ajx from './../../shared/index.js';
const loginForm = $('#login-form');
const homePage = $('#home');

if (loginForm.length > 0) {
  sessionStorage.clear();
  localStorage.clear();
  loginForm.submit((e) => {
    ajx.post('/api/login', {
      "username": $('#username').val(),
      "password": $('#password').val()
    }).then((res) => {
      localStorage.setItem('token', `Bearer ${res.access_token}`);
    }).catch(res => console.log(res));
  })
}