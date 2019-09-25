import ajx from './../../shared/index.js';

const list_id = [];
const courierId = $('#person_id');
const vehicleId = $('#vehicle_id');
const modalSalesInvoices = $('#modal-sales-invoices');
const modalSIFormTable = $('#modal-si-form-table');
const formCreateDelivery = $('#form-create-delivery');
const modalSIForm = $('#modal-si-form');
const tableSiItemDelivery = $('#table-si-item-delivery');
const tableDelivery = $('#table-delivery-schedule');
const EditDeliveryForm = $('#form-edit-delivery');

const createSiFormTable = (target, data) => {
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
      { data: 'customer.name' },
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
        let datas = JSON.parse(sessionStorage.choosed_si);
        const id = e.target.value;
        if (e.target.checked) {
          ajx.get(`/api/sales_invoices/${id}`)
            .then((res) => {
              datas.push(res.sales_invoice);
              sessionStorage.setItem('choosed_si', JSON.stringify(datas));
            })
        } else {
          datas = datas.filter(res => res.id !== parseInt(id));
          sessionStorage.setItem('choosed_si', JSON.stringify(datas));
        }
      });
    }
  });
};

const createSITableDelivery = (target, data) => {
  const format = (d) => {
    let row = '';
    const items = d.transaction_lines;
    items.map((res) => {
      if (formCreateDelivery.length > 0 && res.status === 'open') {
        row += `<tr>
          <td>
            <input type="checkbox" class="transaction_id" name="transaction_id" value="${res.id}" ${res.status !== 'open' ? 'disabled' : 'required' } checked="${res.status}">
          </td>
          <td>${res.status}</td>
          <td>${res.transaction_line.item.description}</td>
          <td>${res.transaction_line.bor}</td>
          <td>${res.transaction_line.brand.name}</td>
          <td>${res.transaction_line.color}</td>
          <td>
            <input type="time" class="form-control" name="eta" ${res.status !== 'open' ? '' : 'required' } value="${res.estimation_time}" ${res.status === 'canceled' ? 'disabled' : '' }>
          </td>
          <td></td>
        </tr>`;
      } else if (res.status !== 'canceled') {
        row += `<tr>
          <td>
            <input type="checkbox" class="transaction_id" name="transaction_id" value="${res.id}" ${res.status !== 'open' ? 'disabled' : 'required' } checked="${res.status}">
          </td>
          <td>${res.status}</td>
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
      {
        data: 'id',
        render(data, type, row) {
          return `${row.customer ? row.customer.name : '-'}`;
        }
      },
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
      $('#table-si-item-delivery tbody td.details-control').each((i, item) => {
        $(item).click((e) => {
          const tr = $(e.target).closest('tr');
          const row = tableSiItemDelivery.DataTable().row( tr );

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
    order: [[3, 'desc']],
    columns: [
      { data: 'courier_code' },
      { data: 'person.name' },
      { data: 'vehicle.number' },
      { data: 'schedule_date' },
      { data: 'schedule_type' },
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

const removeItem = () => {
  $('.remove-item').click((e) => {
    const choosed_si = JSON.parse(sessionStorage.choosed_si);
    const parent = e.target.closest('tr');
    const id = e.currentTarget.id.split('_')[1];
    const latest_choosed_si = choosed_si.filter(res => res.id !== parseFloat(id));
    sessionStorage.setItem('choosed_si', JSON.stringify(latest_choosed_si));
    tableSiItemDelivery.DataTable().row([parent]).remove().draw();
    tableSiItemDelivery.DataTable().destroy();
    createSITableDelivery(tableSiItemDelivery, latest_choosed_si);
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
  createSITableDelivery(tableSiItemDelivery, list_id);
};

if (modalSalesInvoices.length > 0) {
  ajx.get('/api/sales_invoices?filter[]=transaction_status,=,open&filter[]=delivery_status,=,open_partial-scheduled').then((res) => {
    const sales_invoices = res.sales_invoices.data;
    createSiFormTable(modalSIFormTable, sales_invoices);
  }).catch(res => console.log(res));
}

if (modalSIForm.length > 0) {
  modalSIForm.submit((e) => {
    e.preventDefault();
    const choosed_si = JSON.parse(sessionStorage.choosed_si);
    tableSiItemDelivery.DataTable().destroy();
    createSITableDelivery(tableSiItemDelivery, choosed_si);
    $('#modal-sales-invoices').modal('hide');
    $('.check-item').each((i, item) => {
      item.checked = false;
    })
    return false;
  });
}

if (formCreateDelivery.length > 0) {
  sessionStorage.clear();
  sessionStorage.setItem('choosed_si', '[]');
  $('#button-delete').remove();
  formCreateDelivery.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const data = dataFormPickup(e.target);
    ajx.post('/api/delivery_schedules', data).then(res => window.location = '/delivery_schedules').catch(res => {
      const errors = res.responseJSON.errors;
      errorMessage(errors);
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })
}

if (tableDelivery.length > 0) {
  ajx.get('/api/delivery_schedules').then((res) => {
    createTable(tableDelivery, res.delivery_schedules.data);
  }).catch(res => console.log(res));
}

if (EditDeliveryForm.length > 0) {
  sessionStorage.clear();
  sessionStorage.setItem('choosed_si', '[]');
  $('#transaction_id').remove();
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/delivery_schedules/${id}`)
    .then(res => {
      $('#person_id').val(res.delivery_schedule.person_id);
      $('#vehicle_id').val(res.delivery_schedule.vehicle_id);
      $('#date').val(res.delivery_schedule.schedule_date);
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
      const data_line = groupBy(res.delivery_schedule.courier_schedule_lines, 'transaction_id');
      sessionStorage.setItem('choosed_si', JSON.stringify([data_line]));
      generateDataPickupEdit([data_line]);
      const done = res.pickup_schedule.courier_schedule_lines.filter(res => res.status === 'done').length;
      if (done > 0) {
        $('.remove-item').each((i, item) => {
          $(item).addClass('d-none');
        })
      }
    })
    .catch(res => console.log(res));

  EditDeliveryForm.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const data = dataFormPickup(e.target);
    ajx.put(`/api/delivery_schedules/${id}`, data).then(res => window.location = '/delivery_schedules').catch(res => {
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/delivery_schedules/${id}`).then(res => window.location = '/delivery_schedules').catch(res => {
      alert(res.responseJSON.message)
    });
  })
}