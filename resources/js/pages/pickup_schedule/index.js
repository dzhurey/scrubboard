import ajx from './../../shared/index.js';

const courierId = $('#courier_id');
const vehicleId = $('#vehicle_id');
const tablePickup = $('#table-pickup-schedule');
const tableSoItemPickup = $('#table-so-item-pickup');
const createPickupForm = $('#form-create-pickup');
const EditPickupForm = $('#form-edit-pickup');
const chooseSOList = () => {
  $('.so_id').change((e) => {
    const items = JSON.parse(sessionStorage.sales_orders);
    const getId = e.currentTarget.getAttribute('data-id');
    const matchData = items.filter(res => res.id === parseFloat(getId));
    $(`#customer_${getId}`).val(matchData[0].customer.name);
    $(`#sales_date_${getId}`).val(matchData[0].transaction_date);
    $(`#address_${getId}`).val(matchData[0].customer.shipping_address.description);
  })
};
const createSOListDropdown = () => {
  const items = JSON.parse(sessionStorage.sales_orders);
  for (let item of items) {
    const option = document.createElement('option');
    option.value = item.id;
    option.textContent = `${item.id} - ${item.customer.name}`;
    $('.so_id').append(option);

    $('.select2').select2({ 
      theme: 'bootstrap',
      placeholder: 'Choose option',
    });
  }
  chooseSOList();
};
const createTableSOPickupSchedule = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: false,
    pageLength: 10,
    columns: [
      { 
        data: 'id.',
        render(data, type, row) {
          return `<select class="form-control select2 so_id" id="so_${row.id}" data-id="${row.id}" name="transaction_id"><option></option></select>`;
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control" id="customer_${row.id}" read-only disabled data-id="${row.id}" name="customer">`
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control" id="sales_date_${row.id}" read-only disabled data-id="${row.id}" name="sales_date">`
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control" id="address_${row.id}" read-only disabled data-id="${row.id}" name="address">`
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<input type="time" class="form-control" id="eta_${row.id}" data-id="${row.id}" name="eta">`
        }
      }
    ],
    drawCallback: () => {
      createSOListDropdown();
    }
  })
};
const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: true,
    pageLength: 5,
    columns: [
      { data: 'courier.name' },
      { data: 'vehicle.number' },
      { data: 'schedule_date' },
      { data: 'courier_schedule_lines.length' },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="/pickup_schedules/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
          data-placement="top" title="Edit"><img src="assets/images/icons/edit.svg" alt="edit" width="16"></a>`
        },
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};
const dataFormPickup = (tableList) => {
  const courier_schedule_lines = [];
  $('.so_id').each((i, item) => {
    const $parent = item.parentElement.parentElement;
    if ($(item).val() !== '') {
      courier_schedule_lines.push({
        transaction_id: $(item).val(),
        estimation_time: $parent.querySelector('input[name="eta"]').value,
      })
    }
  });
  return {
    courier_id: $('#courier_id').val(),
    vehicle_id: $('#vehicle_id').val(),
    schedule_date: $('#date').val(),
    courier_schedule_lines: courier_schedule_lines,
  }
};

if (courierId.length > 0) {
  ajx.get('/api/couriers').then((res) => {
    const items = res.people.data;
    for (let item of items) {
      const option = document.createElement('option');
      option.value = item.id;
      option.textContent = `${item.name}`;
      courierId.append(option);
    }
  }).catch(res => console.log(res));
}

if (vehicleId.length > 0) {
  ajx.get('/api/vehicles').then((res) => {
    const items = res.vehicles.data;
    for (let item of items) {
      const option = document.createElement('option');
      option.value = item.id;
      option.textContent = `${item.number}`;
      vehicleId.append(option);
    }
  }).catch(res => console.log(res));
}

if (tableSoItemPickup.length > 0) {
  sessionStorage.clear();
  ajx.get('/api/sales_orders').then((res) => {
    sessionStorage.setItem('sales_orders', JSON.stringify(res.sales_orders.data));
    createTableSOPickupSchedule(tableSoItemPickup, res.sales_orders.data);
  }).catch(res => console.log(res));
}

if (createPickupForm.length > 0) {
  $('#button-delete').remove();
  createPickupForm.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const data = dataFormPickup(e.target);
    ajx.post('/api/pickup_schedules', data).then(res => window.location = '/pickup_schedules').catch(res => console.log(res));
    return false;
  })
}

if (EditPickupForm.length > 0) {
  sessionStorage.clear();
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/pickup_schedules/${id}`)
    .then(res => {
      const itemsSO = JSON.parse(sessionStorage.sales_orders);
      $('#courier_id').val(res.pickup_schedule.courier_id);
      $('#vehicle_id').val(res.pickup_schedule.vehicle_id);
      $('#date').val(res.pickup_schedule.schedule_date);
      $('#courier_id, #vehicle_id').select2({ 
        theme: 'bootstrap',
        placeholder: 'Choose option',
      });
      $('.so_id').each((i, item) => {
        if (i <= res.pickup_schedule.courier_schedule_lines.length -1) {
          const $parent = item.parentElement.parentElement;
          const transId = res.pickup_schedule.courier_schedule_lines[i].transaction_id;
          const filterSO = itemsSO.filter(res => res.id === transId);
          $(item).val(transId);
          $parent.querySelector('input[name="eta"]').value = res.pickup_schedule.courier_schedule_lines[i].estimation_time;
          $parent.querySelector('input[name="customer"]').value = filterSO[0].customer.name;
          $parent.querySelector('input[name="sales_date"]').value = filterSO[0].transaction_date;
          $parent.querySelector('input[name="address"]').value = filterSO[0].customer.shipping_address.description;          
          $(item).select2({ 
            theme: 'bootstrap',
            placeholder: 'Choose option',
          });
        }
      });
    })
    .catch(res => console.log(res));

  EditPickupForm.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const data = dataFormPickup(e.target);
    ajx.put(`/api/pickup_schedules/${id}`, data).then(res => window.location = '/pickup_schedules').catch(res => console.log(res));
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/pickup_schedules/${id}`).then(res => window.location = '/pickup_schedules').catch(res => {
      alert(res.responseJSON.message)
    });
  })
}

if (tablePickup.length > 0) {
  ajx.get('/api/pickup_schedules').then((res) => {
    createTable(tablePickup, res.pickup_schedules.data);
  }).catch(res => console.log(res));
}