import ajx from './../../shared/index.js';

const tableVehicle = $('#table-vehicle');
const formCreateVehicle = $('#form-create-vehicle');
const formEditVehicle = $('#form-edit-vehicle');
const createTable = (target, data) => {
  target.DataTable({
    // scrollX: true,
    data: data,
    lengthChange: true,
    lengthMenu: [ 15, 25, 50, 100 ],
    searching: true,
    info: true,
    paging: true,
    pageLength: 15,
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
  ajx.get('/api/vehicles').then((res) => {
    createTable(tableVehicle, res.vehicles.data);
  }).catch(res => console.log(res));
}

if (formCreateVehicle.length > 0) {
  $('#button-delete').remove();
  formCreateVehicle.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formCreateVehicle.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.post('/api/vehicles', data).then(res => window.location = '/vehicles').catch(res => {
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  });
}

if (formEditVehicle.length > 0) {
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/vehicles/${id}`)
    .then(res => {
      $('#number-plate').val(res.vehicle.number);
    })
    .catch(res => console.log(res));

  formEditVehicle.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formEditVehicle.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.put(`/api/vehicles/${id}`, data).then(res => window.location = '/vehicles').catch(res => {
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/vehicles/${id}`).then(res => window.location = '/vehicles').catch(res => {
      alert('Cannot delete vehicle that has been used in transaction')
    });
  })
}
