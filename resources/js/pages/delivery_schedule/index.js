import ajx from './../../shared/index.js';

const tabledelivery = $('#table-delivery-schedule');
const tableSoItemdelivery = $('#table-so-item-delivery');
const createdeliveryForm = $('#form-create-delivery');
const EditdeliveryForm = $('#form-edit-delivery');
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
const createTableSOdeliverySchedule = (target, data) => {
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
          return `<a href="/delivery_schedules/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
          data-placement="top" title="Edit"><img src="assets/images/icons/edit.svg" alt="edit" width="16"></a>`
        },
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};
const dataFormdelivery = (tableList) => {
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

if (tableSoItemdelivery.length > 0) {
  sessionStorage.clear();
  ajx.get('/api/sales_orders').then((res) => {
    sessionStorage.setItem('sales_orders', JSON.stringify(res.sales_orders.data));
    createTableSOdeliverySchedule(tableSoItemdelivery, res.sales_orders.data);
  }).catch(res => console.log(res));
}

if (createdeliveryForm.length > 0) {
  $('#button-delete').remove();
  createdeliveryForm.submit((e) => {
    e.preventDefault();
    const data = dataFormdelivery(e.target);
    ajx.post('/api/delivery_schedules', data).then(res => window.location = '/delivery_schedules').catch(res => console.log(res));
    return false;
  })
}

if (EditdeliveryForm.length > 0) {
  sessionStorage.clear();
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/delivery_schedules/${id}`)
    .then(res => {
      const itemsSO = JSON.parse(sessionStorage.sales_orders);
      $('#courier_id').val(res.delivery_schedule.courier_id);
      $('#vehicle_id').val(res.delivery_schedule.vehicle_id);
      $('#date').val(res.delivery_schedule.schedule_date);
      $('#courier_id, #vehicle_id').select2({ 
        theme: 'bootstrap',
        placeholder: 'Choose option',
      });
      $('.so_id').each((i, item) => {
        if (i <= res.delivery_schedule.courier_schedule_lines.length) {
          const $parent = item.parentElement.parentElement;
          const transId = res.delivery_schedule.courier_schedule_lines[i].transaction_id;
          const filterSO = itemsSO.filter(res => res.id === transId);
          $(item).val(transId);
          $parent.querySelector('input[name="eta"]').value = res.delivery_schedule.courier_schedule_lines[i].estimation_time;
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

  EditdeliveryForm.submit((e) => {
    e.preventDefault();
    const data = dataFormdelivery(e.target);
    ajx.put(`/api/delivery_schedules/${id}`, data).then(res => window.location = '/delivery_schedules').catch(res => console.log(res));
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/delivery_schedules/${id}`).then(res => window.location = '/delivery_schedules').catch(res => {
      alert(res.responseJSON.message)
    });
  })
}

if (tabledelivery.length > 0) {
  ajx.get('/api/delivery_schedules').then((res) => {
    createTable(tabledelivery, res.delivery_schedules.data);
  }).catch(res => console.log(res));
}