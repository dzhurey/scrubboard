import ajx from './../../shared/index.js';
const loginForm = $('#login-form');
const homePage = $('#home');

if (loginForm.length > 0) {
  loginForm.submit((e) => {
    ajx.post('/api/login', {
      "email": $('#email').val(),
      "password": $('#password').val()
    }).then((res) => {
      localStorage.setItem('token', `Bearer ${res.access_token}`);
    }).catch(res => console.log(res));
  })
}