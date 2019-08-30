import ajx from './../../shared/index.js';

const tableCourierPS = $('#table-courier-pickup-schedule');
const formEditCourierPS = $('#form-edit-courier-pickup-schedule');
const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: true,
    pageLength: 5,
    columns: [
      { data: 'transaction.transaction_number' },
      { 
        data: 'transaction.customer.shipping_address.description',
        render(data, type, row) {
          const address = row.transaction.customer.shipping_address;
          return `${address.description}, ${address.district}, ${address.city}, ${address.country} ${address.zip_code}`
        }
      },
      { data: 'estimation_time' },
      { data: 'status' },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="/courier/pickup_schedules/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
          data-placement="top" title="Edit"><img src="${window.location.origin}/assets/images/icons/edit.svg" alt="edit" width="16"></a>`
        },
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};

if (tableCourierPS.length > 0) {
  ajx.get('/api/courier/pickup_schedules').then((res) => {
    createTable(tableCourierPS, res.courier_pickup_schedules.data);
  }).catch(res => console.log(res));
}

if (formEditCourierPS.length > 0) {
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/courier/pickup_schedules/${id}`).then((res) => {
    const data = res.courier_schedule_line;
    const customer = data.transaction.customer;
    const items = data.transaction.transaction_lines;
    debugger;
    // createTable(tableCourierPS, res.courier_pickup_schedules.data);
  }).catch(res => console.log(res));
}