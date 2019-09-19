import ajx from './../../shared/index.js';

const list_id = [];
const courierId = $('#person_id');
const vehicleId = $('#vehicle_id');
const modalSalesOrder = $('#modal-sales-order');
const modalSOFormTable = $('#modal-so-form-table');
const formCreatePickup = $('#form-create-pickup');
const modalSOForm = $('#modal-so-form');
const tableSoItemPickup = $('#table-so-item-pickup');
const tablePickup = $('#table-pickup-schedule');
const EditPickupForm = $('#form-edit-pickup');

const createSOFormTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: false,
    pageLength: 10,
    columns: [
      {
        data: 'id',
        render(data, type, row) {
          return `<input type="checkbox" name="transaction_id" class="check-item" value="${data}" />`;
        },
      },
      { data: 'transaction_number' },
      { 
        data: 'id',
        render(data, type, row) {
          return `${row.customer ? row.customer.name : '-'}`;
        }
      },
      { data: 'pickup_date' },
      {
        data: 'address',
        render(data) {
          return `${data.description}, ${data.district}, ${data.city}, ${data.country} ${data.zip_code}`;
        }
      },
      {
        data: 'transaction_lines.length',
      },
      {
        data: 'id',
        render() {
          return ''
        }
      }
    ],
    drawCallback: () => {
      $('.check-item').change((e) => {
        let datas = JSON.parse(sessionStorage.choosed_so);
        const id = e.target.value;
        if (e.target.checked) {
          ajx.get(`/api/sales_orders/${id}`)
            .then((res) => {
              datas.push(res.sales_order);
              sessionStorage.setItem('choosed_so', JSON.stringify(datas));
            })
        } else {
          datas = datas.filter(res => res.id !== parseInt(id));
          sessionStorage.setItem('choosed_so', JSON.stringify(datas));
        }
      });
    }
  });
};

const createSOTable = (target, data) => {
  const format = (d) => {
    let row = '';
    const items = d.transaction_lines;
    items.map((res) => {
      if (formCreatePickup.length > 0 && res.status === 'open') {
        row += `<tr>
          <td>
            <input type="checkbox" class="transaction_id" name="transaction_id" value="${res.id}" ${res.status !== 'open' ? 'disabled' : 'required' } checked="${res.status}">
          </td>
          <td>${res.status === 'done' ? 'Picked' : res.status}</td>
          <td>${res.item.description}</td>
          <td>${res.bor}</td>
          <td>${res.brand.name}</td>
          <td>${res.color}</td>
          <td>
            <input type="time" class="form-control" name="eta" ${res.status !== 'open' ? '' : 'required' } value="${res.estimation_time}" ${res.status === 'canceled' ? 'disabled' : '' }>
          </td>
          <td></td>
        </tr>`;
      } else if (res.status !== 'canceled') {
        row += `<tr>
          <td>
            <input type="checkbox" class="transaction_id" name="transaction_id" value="${res.transaction_line_id}" ${res.status !== 'open' ? 'disabled' : 'required' } checked="${res.status}">
          </td>
          <td>${res.status === 'done' ? 'Picked' : res.status}</td>
          <td>${res.transaction_line.item.description}</td>
          <td>${res.transaction_line.bor}</td>
          <td>${res.transaction_line.brand.name}</td>
          <td>${res.transaction_line.color}</td>
          <td>
            <input type="time" class="form-control" name="eta" ${res.status !== 'open' ? '' : 'required' } value="${res.estimation_time}" ${res.status === 'canceled' ? 'disabled' : '' }>
          </td>
          <td></td>
        </tr>`;
      }
    });

    return `<table cellpadding="0" cellspacing="0" border="0" width="100%"><thead>
      <tr>
        <th class="checkbox"></th>
        <th>Status</th>
        <th>Item</th>
        <th>BOR</th>
        <th>Brand</th>
        <th>Color</th>
        <th class="th-qty">ETA</th>
        <th></th>
      </tr>
    </thead><tbody>${row}</tbody></table>`;
  };

  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: false,
    pageLength: 10,
    columns: [
      {
        className: 'details-control',
        orderable: false,
        data: null,
        defaultContent: ''
      },
      { data: 'transaction_number' },
      { data: 'customer.name' },
      {
        data: 'address',
        render(data) {
          return `${data.description}, ${data.district}, ${data.city}, ${data.country} ${data.zip_code}`;
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="javascript:void(0)" id="delete_${data}" class="btn btn-light is-small table-action remove-item" data-toggle="tooltip" data-placement="top" title="Reset"><img src="${window.location.origin}/assets/images/icons/trash.svg" alt="edit" width="16"></a>`
        }
      },
    ],
    drawCallback: () => {
      removeItem();
      $('#table-so-item-pickup tbody td.details-control').each((i, item) => {
        $(item).click((e) => {
          const tr = $(e.target).closest('tr');
          const row = tableSoItemPickup.DataTable().row( tr );

          if ( row.child.isShown() ) {
              row.child.hide();
              tr.removeClass('shown');
          }
          else {
              row.child( format(row.data()) ).show();
              tr.addClass('shown');
          }

          $('.transaction_id').click((e) => {
            if (e.target.checked) {
              e.target.closest('tr').querySelector('input[name="eta"]').setAttribute('required', true);
            } else {
              e.target.closest('tr').querySelector('input[name="eta"]').removeAttribute('required')
            }
          });
        })
      });
    },
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
      { data: 'courier_code' },
      { data: 'person.name' },
      { data: 'vehicle.number' },
      { data: 'schedule_date' },
      { data: 'schedule_type' },
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

const removeItem = () => {
  $('.remove-item').click((e) => {
    const choosed_so = JSON.parse(sessionStorage.choosed_so);
    const parent = e.target.closest('tr');
    const id = e.currentTarget.id.split('_')[1];
    const latest_choosed_so = choosed_so.filter(res => res.id !== parseFloat(id));
    sessionStorage.setItem('choosed_so', JSON.stringify(latest_choosed_so));
    tableSoItemPickup.DataTable().row([parent]).remove().draw();
    tableSoItemPickup.DataTable().destroy();
    createSOTable(tableSoItemPickup, latest_choosed_so);
  });
};

const errorMessage = (data) => {
  Object.keys(data).map(key => {
    const $parent = $(`#${key}`).closest('.form-group');
    $parent.addClass('is-error');
    $parent[0].querySelector('.invalid-feedback').innerText = data[key][0];
  });
};

const dataFormPickup = (tableList) => {
  const courier_schedule_lines = [];
  $('.transaction_id').each((i, item) => {
    const $parent = item.closest('tr');
    if ($(item).prop('checked')) {
      courier_schedule_lines.push({
        transaction_line_id: $(item).val(),
        estimation_time: $parent.querySelector('input[name="eta"]').value,
      })
    }
  });
  return {
    person_id: $('#person_id').val(),
    vehicle_id: $('#vehicle_id').val(),
    schedule_date: $('#date').val(),
    courier_schedule_lines: courier_schedule_lines,
  }
};

const generateDataPickupEdit = (list_id) => {
  createSOTable(tableSoItemPickup, list_id);
};

if (modalSalesOrder.length > 0) {
  ajx.get('/api/sales_orders?filter[]=transaction_status,=,open&filter[]=pickup_status,=,open').then((res) => {
    const sales_orders = res.sales_orders.data;
    createSOFormTable(modalSOFormTable, sales_orders);
  }).catch(res => console.log(res));
}

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

if (modalSOForm.length > 0) {
  modalSOForm.submit((e) => {
    e.preventDefault();
    const choosed_so = JSON.parse(sessionStorage.choosed_so);
    tableSoItemPickup.DataTable().destroy();
    createSOTable(tableSoItemPickup, choosed_so);
    $('#modal-sales-order').modal('hide');
    $('.check-item').each((i, item) => {
      item.checked = false;
    })
    return false;
  });
}

if (formCreatePickup.length > 0) {
  sessionStorage.clear();
  sessionStorage.setItem('choosed_so', '[]');
  $('#button-delete').remove();
  formCreatePickup.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const data = dataFormPickup(e.target);
    ajx.post('/api/pickup_schedules', data).then(res => window.location = '/pickup_schedules').catch(res => {
      const errors = res.responseJSON.errors;
      errorMessage(errors);
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })
}

if (tablePickup.length > 0) {
  ajx.get('/api/pickup_schedules').then((res) => {
    createTable(tablePickup, res.pickup_schedules.data);
  }).catch(res => console.log(res));
}

if (EditPickupForm.length > 0) {
  sessionStorage.clear();
  sessionStorage.setItem('choosed_so', '[]');
  $('#transaction_id').remove();
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/pickup_schedules/${id}`)
    .then(res => {
      $('#person_id').val(res.pickup_schedule.person_id);
      $('#vehicle_id').val(res.pickup_schedule.vehicle_id);
      $('#date').val(res.pickup_schedule.schedule_date);
      $('#person_id, #vehicle_id').select2({
        theme: 'bootstrap',
        placeholder: 'Choose option',
      });
      const groupBy = (xs, key) => {
        return xs.reduce((rv, x) => {
          (rv['transaction_lines'] = rv['transaction_lines'] || []).push(x);
          if (x.status === 'done') $('#button-delete').remove();
          return {
            id: x[key],
            address: x.transaction_line.address,
            customer: x.transaction_line.transaction.customer || x.transaction_line.transaction.agent,
            transaction_number: x.transaction_line.transaction_number,
            transaction_lines: rv['transaction_lines'],
          };
        }, {});
      };
      const data_line = groupBy(res.pickup_schedule.courier_schedule_lines, 'transaction_id');
      sessionStorage.setItem('choosed_so', JSON.stringify([data_line]));
      generateDataPickupEdit([data_line]);
      const done = res.pickup_schedule.courier_schedule_lines.filter(res => res.status === 'done').length;
      if (done > 0) {
        $('.remove-item').each((i, item) => {
          $(item).addClass('d-none');
        })
      } 
    })
    .catch(res => console.log(res));

  EditPickupForm.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const data = dataFormPickup(e.target);
    ajx.put(`/api/pickup_schedules/${id}`, data).then(res => window.location = '/pickup_schedules').catch(res => {
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/pickup_schedules/${id}`).then(res => window.location = '/pickup_schedules').catch(res => {
      alert(res.responseJSON.message)
    });
  })
}