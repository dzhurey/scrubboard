import ajx from './../../shared/index.js';

let priceList = [];
const tableUser = $('#table-user');
const formCreateUser = $('#form-create-user');
const formEditUser = $('#form-edit-user');
const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: true,
    pageLength: 5,
    columns: [
      { data: 'name' },
      {
        data: 'user',
        render(data) {
          return data.email
        }
      },
      {
        data: 'user',
        render(data) {
          return data.role
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="/people/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
          data-placement="top" title="Edit"><img src="assets/images/icons/edit.svg" alt="edit" width="16"></a>`
        },
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};
const assignValue = (data) => {
  const keys = Object.keys(data);
  keys.forEach((key) => {
    if($(`input[name=${key}]`).length > 0) {
      const input = $(`input[name=${key}]`);
      if(input.attr('type') === 'radio') {
        $(`#${key}_${data[key]}`).attr('checked', true);
      } else {
        input.val(data[key]);
      }
    }
    if($(`select[name=${key}]`).length > 0) $(`select[name=${key}]`).val(key === 'role' ? data[user.role] : data[key]);
  })
};

if (tableUser.length > 0) {
  ajx.get('/api/people').then((res) => {
    createTable(tableUser, res.people.data);
  }).catch(res => console.log(res));
}

if (formCreateUser.length > 0) {
  formCreateUser.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formCreateUser.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.post('/api/people', data).then(res => window.location = '/people').catch(res => console.log(res));
    return false;
  });
}

if (formEditUser.length > 0) {
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/people/${id}`)
    .then((res) => {
      assignValue(res.person);
      $('#email').val(res.person.user.email);
      $('#email').attr('disabled', true);
      $('#address').val(res.person.address);
      $('#district').val(res.person.district);
      $('#city').val(res.person.city);
      $('#country').val(res.person.country);
      $('#zip_code').val(res.person.city);
    })
    .catch(res => console.log(res));

  formEditUser.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formEditUser.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.put(`/api/people/${id}`, data).then(res => window.location = '/people').catch(res => console.log(res));
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/people/${id}`).then(res => window.location = '/people').catch(res => {
      alert(res.responseJSON.message)
    });
  })
}
