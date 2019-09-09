import ajx from './../../shared/index.js';

const courierId = $('#courier_id');
const vehicleId = $('#vehicle_id');
const modalSalesOrder = $('#modal-sales-order');
const modalSOFormTable = $('#modal-so-form-table');
const formCreatePickup = $('#form-create-pickup');
const modalSOForm = $('#modal-so-form');
const tableSoItemPickup = $('#table-so-item-pickup');

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
        const datas = JSON.parse(sessionStorage.choosed_so);
        const id = e.target.value;
        if (e.target.checked) {
          ajx.get(`/api/sales_orders/${id}`)
            .then((res) => {
              datas.push(res.sales_order);
              sessionStorage.setItem('choosed_so', JSON.stringify(datas));
            })
        } else {
          datas = datas.filter(res => res.id !== id);
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
      row += `<tr><td><input type="checkbox" class="transaction_id" name="transaction_id" value="${res.id}"></td><td>${res.item.description}</td><td>${res.bor}</td><td>${res.brand.name}</td><td>${res.color ? res.color : '-'}</td><td><input type="time" class="form-control" id="eta_${res.id} name="eta"></td><td></td></tr>`;
    });

    return `<table cellpadding="0" cellspacing="0" border="0" width="100%"><thead>
      <tr>
        <th class="checkbox"></th>
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
          return ''
        }
      },
    ],
    drawCallback: () => {
      $('#table-so-item-pickup tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableSoItemPickup.DataTable().row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
    },
  })
};

if (modalSalesOrder.length > 0) {
  ajx.get('/api/sales_orders?filter[]=transaction_status,=,open').then((res) => {
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
    createSOTable(tableSoItemPickup, choosed_so);
    $('#modal-sales-order').modal('hide');
    return false;
  });
}

if (formCreatePickup.length > 0) {
  sessionStorage.clear();
  sessionStorage.setItem('choosed_so', '[]');
}