import ajx from './../../shared/index.js';
import modalPhotos from './../../components/modal/modal-photos.js';

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
    // scrollX: true,
    data: data,
    lengthChange: true,
    lengthMenu: [ 15, 25, 50, 100 ],
    searching: true,
    info: true,
    paging: true,
    pageLength: 15,
    columns: [
      {
        data: 'id',
        render(data, type, row) {
          return `<input type="radio" name="transaction_id" class="check-item" value="${data}" />`;
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
          return `${data.description}, ${data.district}, <br/>${data.city}, ${data.country} ${data.zip_code}`;
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
              datas = [];
              datas.push(res.sales_order);
              sessionStorage.setItem('choosed_so', JSON.stringify(datas));
            })
        }
      });
    }
  });
};

const createSOTable = (target, data) => {
  const format = (d) => {
    let row = '';
    const items = d.transaction_lines;
    modalPhotos(items);
    items.map((res) => {
      const transactionLine = res.transaction_line === undefined ? res : res.transaction_line
      const documentStatus = $('#document_status').val();
      // ${res.status !== 'open' ? '' : 'required' }
      // ${res.status === 'done' || res.status === 'canceled' || res.status === 'scheduled' || documentStatus == 'canceled' ? 'disabled readonly' : '' }
      // ${res.status === 'done' || res.status === 'canceled' || res.status === 'scheduled' || documentStatus == 'canceled' ? 'disabled' : '' }
      // ${res.status !== 'open' || documentStatus == 'canceled' ? 'disabled' : 'required' }
      // ${res.status !== 'open' || documentStatus == 'canceled' ? 'disabled readonly' : 'required' }
      if (formCreatePickup.length > 0 && res.status === 'open') {
        row += `<tr>
          <td>
            <input type="checkbox" class="transaction_id" name="transaction_id" value="${res.id}" ${res.status === 'done' || res.status === 'canceled' || res.status === 'scheduled' ? '' : 'checked'}>
          </td>
          <td class="transaction_line_status">${res.status === 'done' ? 'Picked' : res.status}</td>
          <td>${transactionLine.item.description}</td>
          <td>${transactionLine.bor}</td>
          <td>${transactionLine.brand !== null ? transactionLine.brand.name : ''}</td>
          <td>${transactionLine.color}</td>
          <td>
            <input type="time" class="form-control" name="eta" value="${res.estimation_time}">
          </td>
          <td>${res.files && res.files.length > 0 ? res.files[0].created_at : '-'}</td>
          ${res.files && res.files.length > 0 ? '<td><a href="javascript:void(0)" data-id="' + res.id + '" data-toggle="modal" data-target="#modal-photos"><i class="fa fa-image"></i> See photos</a></td>' : ''}
          <td></td>
        </tr>`;
      } else if (res.status !== 'canceled') {
        row += `<tr>
          <td>
            <input type="checkbox" class="transaction_id" name="transaction_id" value="${res.id}" ${res.status === 'done' || res.status === 'canceled' || res.status === 'scheduled' ? '' : 'checked'}>
          </td>
          <td class="transaction_line_status">${res.status === 'done' ? 'Picked' : res.status}</td>
          <td>${transactionLine.item.description}</td>
          <td>${transactionLine.bor}</td>
          <td>${transactionLine.brand !== null ? transactionLine.brand.name : ''}</td>
          <td>${transactionLine.color}</td>
          <td>
            <input type="time" class="form-control" name="eta" value="${res.estimation_time}">
          </td>
          <td>${res.files && res.files.length > 0 ? res.files[0].created_at : '-'}</td>
          ${res.files && res.files.length > 0 ? '<td><a href="javascript:void(0)" data-id="' + res.id + '" data-toggle="modal" data-target="#modal-photos"><i class="fa fa-image"></i> See photos</a></td>' : ''}
          <td></td>
        </tr>`;
      } else if (res.status === 'canceled') {
        row += `<tr><td colspan="8" align="center">Item has been cancel</td></tr>`
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
        <th>Picked</th>
        ${items.filter((res) => res.files && res.files.length > 0).length > 0 ? '<th>Photos</th>' : ''}
        <th></th>
      </tr>
    </thead><tbody>${row}</tbody></table>`;
  };

  target.DataTable({
    // scrollX: true,
    data: data,
    lengthChange: false,
    lengthMenu: [ 15, 25, 50, 100 ],
    searching: false,
    info: false,
    paging: false,
    pageLength: 15,
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
        data: 'customer.shipping_addresses',
        render(data) {
          const options = data.map((res) => {
            return `<option value="${res.id}">${res.description}, ${res.district}, ${res.city}, ${res.country} ${res.zip_code}</option>`
          })
          return `<select id="address_id" class="form-control select2" name="address_id">${options.join('')}</select>`
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
      $('#address_id').val(sessionStorage.address_id);
      $('#address_id').select2({
        theme: 'bootstrap',
        placeholder: 'Choose address',
      }).trigger('change');
      if (EditPickupForm.length > 0) {
        $('.remove-item').remove();
      }
      $('#table-so-item-pickup tbody td.details-control').each((i, item) => {
        $(item).click((e) => {
          const tr = $(e.target).closest('tr');
          const row = tableSoItemPickup.DataTable().row( tr );
          $('#form-create-pickup').removeClass('was-validated');

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
    // scrollX: true,
    data: data,
    lengthChange: true,
    lengthMenu: [ 15, 25, 50, 100 ],
    searching: true,
    info: true,
    paging: true,
    pageLength: 15,
    order: [[3, 'desc']],
    columns: [
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="/pickup_schedules/${data}/edit">${row.courier_code}</a>`
        }
      },
      { data: 'person.name' },
      { data: 'vehicle.number' },
      { data: 'schedule_date' },
      {
        data: 'id',
        render(data, type, row) {
          return row.transaction.transaction_status;
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return row.transaction.transaction_number;
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return row.transaction.customer.name;
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          const agent = row.transaction.agent;
          const customer = row.transaction.customer;
          return `${row.transaction.is_own_address ? customer.name : agent.name}`
        }
      },
      {
        data: 'address',
        render(data, type, row) {
          return `${data.description}, ${data.district}, <br/>${data.city}, ${data.country} ${data.zip_code}`
        }
      },
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
    const status = $parent.querySelector('.transaction_line_status').innerHTML
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
    address_id: $('#address_id').val(),
    courier_schedule_lines: courier_schedule_lines,
  }
};

const generateDataPickupEdit = (list_id) => {
  createSOTable(tableSoItemPickup, list_id);
};

if (modalSalesOrder.length > 0) {
  ajx.get('/api/sales_orders?filter[]=transaction_status,=,open&filter[]=pickup_status,!=,done_partial_scheduled').then((res) => {
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
    const isSubmit = data.courier_schedule_lines.filter(res => res.estimation_time === '').length === 0;
    if (isSubmit && data.courier_schedule_lines.length > 0) {
      ajx.post('/api/pickup_schedules', data).then(res => window.location = '/pickup_schedules').catch(res => {
        const errors = res.responseJSON.errors;
        errorMessage(errors);
        console.log(res)
        $('button[type="submit"]').attr('disabled', false);
      });
    } else {
      alert('Data incompleted');
      $('button[type="submit"]').attr('disabled', false);
    }
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
      $('#document_status').val(res.pickup_schedule.transaction.transaction_status);
      sessionStorage.setItem('address_id', res.pickup_schedule.address.id);
      $('#person_id, #vehicle_id').select2({
        theme: 'bootstrap',
        placeholder: 'Choose option',
      }).trigger('change');
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
      if (isCanceled(res)) {
        disableAllForm()
      }
    })
    .catch(res => console.log(res));

  EditPickupForm.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const data = dataFormPickup(e.target);
    const isSubmit = data.courier_schedule_lines.filter(res => res.estimation_time === '').length === 0;
    if (isSubmit && data.courier_schedule_lines.length > 0) {
      ajx.put(`/api/pickup_schedules/${id}`, data).then(res => window.location = '/pickup_schedules').catch(res => {
        console.log(res)
        $('button[type="submit"]').attr('disabled', false);
      });
    } else {
      alert('Data incompleted');
      $('button[type="submit"]').attr('disabled', false);
    }
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/pickup_schedules/${id}`).then(res => window.location = '/pickup_schedules').catch(res => {
      alert(res.responseJSON.message)
    });
  })
}

const isCanceled = (res) => {
  return res.pickup_schedule.document_status == 'canceled'
}

const disableAllForm = () => {
  EditPickupForm.find('input, select').attr('disabled', 'disabled')
  EditPickupForm.find('button').addClass('d-none')
}