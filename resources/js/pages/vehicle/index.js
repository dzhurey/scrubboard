import ajx from './../../shared/index.js';

const tableVehicle = $('#table-vehicle');
const formCreateSubCategory = $('#form-create-vehicle');
const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    columns: [
      { data: 'number' },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="/vehicles/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
          data-placement="top" title="Edit"><img src="assets/images/icons/edit.svg" alt="edit" width="16"></a>`
        },
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};

if (tableVehicle.length > 0) {
  ajx.get('/vehicles').then((res) => {
    createTable(tableVehicle, res.vehicles.data);
  }).catch(res => console.log(res));
}