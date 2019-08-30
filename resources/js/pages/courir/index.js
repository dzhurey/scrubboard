import ajx from './../../shared/index.js';

let priceList = [];
const tableCourier = $('#table-courier');
const formCreateCourier = $('#form-create-courier');
const formEditCourier = $('#form-edit-courier');
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
          return `<a href="/couriers/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
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

if (tableCourier.length > 0) {
  ajx.get('/api/couriers').then((res) => {
    createTable(tableCourier, res.people.data);
  }).catch(res => console.log(res));
}

if (formCreateCourier.length > 0) {
  formCreateCourier.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formCreateCourier.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.post('/api/couriers', data).then(res => {
      window.location = '/couriers'
    }).catch(res => {
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  });
}

if (formEditCourier.length > 0) {
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/couriers/${id}`)
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

  formEditCourier.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formEditCourier.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.put(`/api/couriers/${id}`, data).then(res => window.location = '/couriers').catch(res => {
      console.log(res);
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/couriers/${id}`).then(res => window.location = '/couriers').catch(res => {
      alert(res.responseJSON.message)
    });
  })
}
