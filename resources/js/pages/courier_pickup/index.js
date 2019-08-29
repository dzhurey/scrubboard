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
  
}