import ajx from './../../shared/index.js';

const transaction_lines = [];
const customerList = $('#customer_id');
const outletList = $('#outlet');
const orderType = $('#order_type');
const statusOrder = $('#status_order');
const listItems = $('.list-item');
const formCreateSalesOrder = $('#form-create-sales-order');
const tableSOItems = $('#table-so-item');
const chooseCustomer = () => {
  customerList.change((e) => {
    if(!$.active) {
      ajx.get(`/api/customers/${e.target.value}`).then((res) => {
        ajx.get(`/api/prices/${res.customer.price_id}`).then((res) => {
          const prices = res.price.price_lines;
          sessionStorage.clear();
          sessionStorage.setItem('prices', JSON.stringify(prices));
          createTableSO(tableSOItems, prices);
        }).catch(res => console.log(res));
      }).catch(res => console.log(res));
    }
  })
};
const totalBeforeDisc = () => {
  let price = 0;
  const totalBeforeDiscField = $('#total-bd');
  const itemPrice = $('.item_total');
  itemPrice.each((i, item) => {
    price = parseFloat(price) + parseFloat(item.value);
    totalBeforeDiscField.val(price);
  });
};
const createItemListDropdown = () => {
  const items = JSON.parse(sessionStorage.prices);
  for (let item of items) {
    const option = document.createElement('option');
    ajx.get(`/api/items/${item.item_id}`).then((res) => {
      option.value = item.item_id;
      option.textContent = `${res.item.description} - ${res.item.price}`;
      $('.item_id').append(option);
    }).catch(res => console.log(res));
  }

  $('.select2').select2({ 
    theme: 'bootstrap',
    placeholder: 'Choose option',
  });

  $('.select2').change((e) => {
    const items = JSON.parse(sessionStorage.prices);
    const id = e.target.getAttribute('data-id');
    const value = e.target.value;
    const data = items.filter(res => parseInt(value) === res.item_id);
    $(`#quantity_${id}`).val('1');
    $(`#discount_${id}`).val('0');
    $(`#unit_price_${id}`).val(data.length > 0 ? data[0].amount : '0');
    $(`#amount_${id}`).val(data.length > 0 ? data[0].amount : '0');
    totalBeforeDisc();
  })

  $('.discount, .quantity').change((e) => {
    const items = JSON.parse(sessionStorage.prices);
    const id = e.target.getAttribute('data-id');
    const itemQuantity = $(`#quantity_${id}`).val();
    const itemPrice = $(`#unit_price_${id}`).val();
    const discPrice = $(`#discount_${id}`).val();
    const countItemPrice = parseFloat(itemPrice) * parseFloat(itemQuantity);
    const calculate = discPrice !== '0' && itemQuantity !== '0' ? parseFloat(countItemPrice) - (parseFloat(discPrice)/100 * parseFloat(countItemPrice)): parseFloat(countItemPrice);
    $(`#amount_${id}`).val(parseFloat(calculate).toFixed(2));
    totalBeforeDisc();
  })

  $('.table-action').click((e) => {
    const id = e.currentTarget.getAttribute('data-id');
    $(`#item_id_${id}`).val('');
    $(`#item_id_${id}`).select2('destroy');
    $(`#item_id_${id}`).select2({ 
      theme: 'bootstrap',
      placeholder: 'Choose option',
    });
    $(`#quantity_${id}`).val('0');
    $(`#discount_${id}`).val('0');
    $(`#unit_price_${id}`).val('0');
    $(`#amount_${id}`).val('0');
  });
};
const createTableSO = (target, data) => {
  target.DataTable({
    destroy: true,
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paginate: false,
    pageLength: 5,
    columns: [
      { 
        data: 'id',
        render(data, type, row) {
          return `<select class="form-control select2 item_id" id="item_id_${row.item_id}" data-id="${row.item_id}" name="item_id" required><option></option></select>`;
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control" id="note_${row.item_id}" data-id="${row.item_id}" name="note">`
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control quantity text-right" id="quantity_${row.item_id}" data-id="${row.item_id}" value="0" name="quantity">`
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control discount text-right" id="discount_${row.item_id}" data-id="${row.item_id}" value="0" name="discount">`
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control text-right" id="unit_price_${row.item_id}" data-id="${row.item_id}" name="unit_price" value="0" readonly>`
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control text-right item_total" id="amount_${row.item_id}" data-id="${row.item_id}" name="amount" value="0" readonly>`
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="javascript:void(0)" data-id="${row.item_id}" class="btn btn-light is-small table-action" data-toggle="tooltip"
          data-placement="top" title="Reset"><img src="./../assets/images/icons/trash.svg" alt="edit" width="16"></a>`
        },
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
      createItemListDropdown();
      chooseCustomer();
    }
  })
};

if (customerList.length > 0) {
  ajx.get('/api/customers').then((res) => {
    const items = res.customers.data;
    for (let item of items) {
      const option = document.createElement('option');
      option.value = item.id;
      option.textContent = `${item.name}`;
      customerList.append(option);
    }
  }).catch(res => console.log(res));
}

if (outletList.length > 0) {
  ajx.get('/api/agents').then((res) => {
    const items = res.agents.data;
    for (let item of items) {
      const option = document.createElement('option');
      option.value = item.id;
      option.textContent = `${item.name}`;
      outletList.append(option);
    }
  }).catch(res => console.log(res));
}

if (formCreateSalesOrder.length > 0) {
  statusOrder.val(orderType.val() === 'general' ? 'open' : 'closed');
  orderType.change((e) => {
    statusOrder.val(e.target.value === 'general' ? 'open' : 'closed');
  });
  chooseCustomer();
}

if (formCreateSalesOrder.length > 0) {
  formCreateSalesOrder.submit((e) => {
    e.preventDefault();
    $('.item_id').each((i, item) => {
      const discount_amount = item.parentElement.parentElement.querySelector('input[name="unit_price"]').value - item.parentElement.parentElement.querySelector('input[name="amount"]').value;
      transaction_lines.push({
        item_id: $(item).val() === '' ? '0' : $(item).val(),
        note: item.parentElement.parentElement.querySelector('input[name="note"]').value,
        quantity: item.parentElement.parentElement.querySelector('input[name="quantity"]').value,
        unit_price: item.parentElement.parentElement.querySelector('input[name="unit_price"]').value,
        discount: item.parentElement.parentElement.querySelector('input[name="discount"]').value,
        amount: item.parentElement.parentElement.querySelector('input[name="amount"]').value,
        discount_amount: '0'
      })
    })

    const data = {
      customer_id: $('#customer_id').val(),
      agent_id: $('#outlet').val(),
      transaction_date: $('#transaction_date').val(),
      pickup_date: $('#pickup_date').val(),
      delivery_date: $('#delivery_date').val(),
      original_amount: $('#original_amount').val(),
      discount: $('#discount').val(),
      discount_amount: $('#discount_amount').val(),
      total_amount: $('#total_amount').val(),
      note: $('#note').val(),
      order_type: $('#order_type').val(),
      status_order: $('#status_order').val(),
      freight: $('#freight').val(),
      transaction_lines: transaction_lines,
    }
    ajx.post('/api/sales_orders', data).then(res => window.location = '/sales_orders').catch(res => console.log(res));
    return false;
  })
}