import ajx from './../../shared/index.js';

const tableCourier = $('#table-courier');
const formCreateCourier = $('#form-create-courier');
const formEditCourier = $('#form-edit-courier');

const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    columns: [
      { data: 'name' },
      { data: 'phone_number' },
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
};``

if (tableCourier.length > 0) {
  ajx.get('/api/couriers').then((res) => {
    createTable(tableCourier, res.couriers.data);
  }).catch(res => {
    console.log(res)
    if (res.status == 401) {
      window.location = '/login'
    }
  });
}

if (formCreateCourier.length > 0) {
  $('#button-delete').remove();
  formCreateCourier.submit((e) => {
    e.preventDefault();
    const dataForm = formCreateCourier.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.post('/api/couriers', data).then(res => {window.location = '/couriers'}).catch(res => {console.log(res)});
    return false;
  });
}

if (formEditCourier.length > 0) {
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/couriers/${id}`)
    .then(res => {
      $('#number-plate').val(res.courier.number);
    })
    .catch(res => console.log(res));

  formEditCourier.submit((e) => {
    e.preventDefault();
    const dataForm = formEditCourier.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.put(`/api/couriers/${id}`, data).then(res => {
      return window.location = '/couriers'
    }).catch(res => console.log(res));
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/couriers/${id}`).then(res => window.location = '/couriers').catch(res => {
      alert(res.responseJSON.message)
    });
  })
}