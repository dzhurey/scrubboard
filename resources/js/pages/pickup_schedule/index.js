import ajx from './../../shared/index.js';

const courierId = $('#courier_id');
const vehicleId = $('#vehicle_id');
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
    $(`#address_${getId}`).val(matchData[0].customer.name);
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
const createTable = (target, data) => {
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
    const items = res.couriers.data;
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
    createTable(tableSoItemPickup, res.sales_orders.data);
  }).catch(res => console.log(res));
}

if (createPickupForm.length > 0) {
  $('#button-delete').remove();
  createPickupForm.submit((e) => {
    e.preventDefault();
    const data = dataFormPickup(e.target);
    ajx.post('/api/pickup_schedules', data).then(res => window.location = '/pickup_schedules').catch(res => console.log(res));
    return false;
  })
}

if (EditPickupForm.length > 0) {
  sessionStorage.clear();
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  EditPickupForm.submit((e) => {
    e.preventDefault();
    const data = dataFormPickup(e.target);
    ajx.post(`/api/pickup_schedules/${id}`, data).then(res => window.location = '/pickup_schedules').catch(res => console.log(res));
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/pickup_schedules/${id}`).then(res => window.location = '/pickup_schedules').catch(res => {
      alert(res.responseJSON.message)
    });
  })
}