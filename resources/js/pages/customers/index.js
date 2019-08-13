import ajx from './../../shared/index.js';

const tableCustomer = $('#table-customer');
const formCreateCustomer = $('#form-create-customer');
const formEditCustomer = $('#form-edit-customer');
const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    columns: [
      { data: 'id' },
      { data: 'name' },
      { data: 'phone_number' },
      { data: 'email' },
      { data: 'created_at' },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="/customers/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
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
      if(input.attr('type') === 'radio') $(`#${key}_${data[key]}`).attr('checked', true);
      input.val(data[key]);
    }
    if($(`select[name=${key}]`).length > 0) $(`select[name=${key}]`).val(data[key]);
    if($(`textarea[name=${key}]`).length > 0) $(`textarea[name=${key}]`).val(data[key]);
  })
};

if (tableCustomer.length > 0) {
  ajx.get('/customers').then((res) => {
    createTable(tableCustomer, res.customers.data);
  }).catch(res => console.log(res));
}

if (formEditCustomer.length > 0) {
  const urlArray = window.location.href.split('/');
  const idCustomer = urlArray[urlArray.length - 2];
  ajx.get(`/customers/${idCustomer}`)
    .then(res => assignValue(res.customer))
    .catch(res => console.log(res));

  formEditCustomer.submit((e) => {
    e.preventDefault();
    const dataForm = formEditCustomer.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.put(`/customers/${idCustomer}/update`, data).then(res => window.location = '/customers').catch(res => console.log(res));
    return false;
  })
}

if (formCreateCustomer.length > 0) {
  $('#button-delete').remove();
  formCreateCustomer.submit((e) => {
    e.preventDefault();
    const dataForm = formCreateCustomer.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.post('/customers', data).then(res => window.location = '/customers').catch(res => console.log(res));
    return false;
  })
}