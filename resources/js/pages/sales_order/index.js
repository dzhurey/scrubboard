import ajx from './../../shared/index.js';

let idCustomer = '';
let idAgent = '';
const transaction_lines = [];
const customerList = $('#customer_id');
const outletList = $('#outlet');
const orderType = $('#order_type');
const statusOrder = $('#status_order');
const listItems = $('.list-item');
const tableSalesOrder = $('#table-sales-order');
const formCreateSalesOrder = $('#form-create-sales-order');
const formEditSalesOrder = $('#form-edit-sales-order');
const tableSOItems = $('#table-so-item');
const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: true,
    pageLength: 5,
    columns: [
      { data: 'customer.name' },
      { data: 'agent.name' },
      { data: 'order_type' },
      { data: 'transaction_date' },
      { data: 'pickup_date' },
      { data: 'delivery_date' },
      { 
        data: 'total_amount',
        render(data) {
          return parseFloat(data).toFixed(0)
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="/sales_orders/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
          data-placement="top" title="Edit"><img src="assets/images/icons/edit.svg" alt="edit" width="16"></a>`
        },
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};
const getDataTableSO = (id) => {
  ajx.get(`/api/customers/${id}`).then((res) => {
    ajx.get(`/api/prices/${res.customer.price_id}`).then((res) => {
      const prices = res.price.price_lines;
      sessionStorage.clear();
      sessionStorage.setItem('prices', JSON.stringify(prices));
      createTableSO(tableSOItems, prices);
    }).catch(res => console.log(res));
  }).catch(res => console.log(res));
}
const chooseCustomer = () => {
  customerList.change((e) => {
    if(!$.active) getDataTableSO(e.target.value);
  })
};
const totalBeforeDisc = () => {
  let price = 0;
  const totalBeforeDiscField = $('#total-bd');
  const itemPrice = $('.item_total');
  itemPrice.each((i, item) => {
    price = parseFloat(price) + parseFloat(item.value);
    totalBeforeDiscField.val(price);
    $('#original_amount').val(price);
    finalTotal($('#discount').val());
  });
  $('#discount').change((e) => finalTotal(e.target.value));
  $('#freight').change((e) => finalTotal($('#discount').val(), e.target.value));
};
const finalTotal = (value, freightValue) => {
  const discount_amount = $('#discount_amount');
  const original_amount = $('#original_amount').val();
  const discountCount = parseFloat(value)/100 * parseFloat(original_amount);
  const discount = discount_amount.val(parseFloat(discountCount));
  const freight = freightValue ? freightValue : $('#freight').val();
  const total = parseFloat(original_amount) - parseFloat(discount.val()) + parseFloat(freight);
  $('#total_amount').val(parseFloat(total));
};

const createItemListDropdown = () => {
  const items = JSON.parse(sessionStorage.prices);
  for (let item of items) {
    const option = document.createElement('option');
    ajx.get(`/api/items/${item.item_id}`).then((res) => {
      option.value = item.item_id;
      option.textContent = `${res.item.description}`;
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
    $(`#unit_price_${id}`).val(data.length > 0 ? parseFloat(data[0].amount).toFixed(0) : '0');
    $(`#amount_${id}`).val(data.length > 0 ? parseFloat(data[0].amount).toFixed(0) : '0');
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
    $(`#amount_${id}`).val(parseFloat(calculate));
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
          data-placement="top" title="Reset"><img src="${window.location.origin}/assets/images/icons/trash.svg" alt="edit" width="16"></a>`
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
      if ($(item).val() !== '') {
        const target = item.parentElement.parentElement;
        const unit_price = target.querySelector('input[name="unit_price"]').value;
        const amount = target.querySelector('input[name="amount"]').value;
        const discount_amount = parseFloat(unit_price) - parseFloat(amount);
        transaction_lines.push({
          item_id: $(item).val(),
          note: target.querySelector('input[name="note"]').value,
          quantity: target.querySelector('input[name="quantity"]').value,
          unit_price: unit_price,
          discount: target.querySelector('input[name="discount"]').value,
          amount: amount,
          discount_amount: discount_amount
        })
      }
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

if (tableSalesOrder.length > 0) {
  ajx.get('/api/sales_orders').then((res) => {
    createTable(tableSalesOrder, res.sales_orders.data);
  }).catch(res => console.log(res));
}

if (formEditSalesOrder.length > 0) {
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/sales_orders/${id}`)
    .then((res) => {
      $('#customer_id').val(res.sales_order.customer_id);
      $('#outlet').val(res.sales_order.agent_id);
      $('#order_type').val(res.sales_order.order_type);
      $('#status_order').val(res.sales_order.order_type === 'general' ? 'open' : 'closed')
      ;
      $('#transaction_date').val(res.sales_order.transaction_date);
      $('#pickup_date').val(res.sales_order.pickup_date);
      $('#delivery_date').val(res.sales_order.delivery_date);
      $('.select2').select2({
        theme: 'bootstrap',
        placeholder: 'Choose option',
      }).trigger('change');
      getDataTableSO(res.sales_order.customer_id);
    })
    .catch(res => console.log(res));

}