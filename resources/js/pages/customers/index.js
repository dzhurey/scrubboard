import ajx from './../../shared/index.js';

const tableCustomer = $('#table-customer');
const formCreateCustomer = $('#form-create-customer');
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

if (tableCustomer.length > 0) {
  ajx.get('/customers').then((res) => {
    createTable(tableCustomer, res.customers.data);
  }).catch(res => console.log(res));
}

formCreateCustomer.submit((e) => {
  const dataForm = formCreateCustomer.serializeArray();
  const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.name === 'gender' || y.name === 'bebe_gender' ? [`${y.value}`] : y.value }), {});
  ajx.post('/customers', data).then(res => console.log(res)).catch(res => console.log(res));
})