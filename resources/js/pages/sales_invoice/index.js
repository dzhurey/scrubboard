import ajx from './../../shared/index.js';

const transaction_lines = [];
const tableInvoice = $('#table-sales-invoice');
const salesOrderList = $('#sales_order_id');
const formCreateSalesInvoice = $('#form-create-sales-invoice');
const formEditSalesInvoice = $('#form-edit-sales-invoice');
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
      { data: 'id' },
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
          return `<a href="/sales_invoices/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
          data-placement="top" title="Edit"><img src="assets/images/icons/edit.svg" alt="edit" width="16"></a>`
        },
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};

if (tableInvoice.length > 0) {
  ajx.get('/api/sales_invoices').then((res) => {
    createTable(tableInvoice, res.sales_invoices.data);
  }).catch(res => console.log(res));
}

if (salesOrderList.length > 0) {
  ajx.get('/api/sales_orders').then((res) => {
    const items = res.sales_orders.data;
    for (let item of items) {
      const option = document.createElement('option');
      option.value = item.id;
      option.textContent = `#${item.id} - ${item.customer.name}`;
      salesOrderList.append(option);
    }
  }).catch(res => console.log(res));
}


salesOrderList.change((e) => {
  const salesOrderSelected = salesOrderList.val();
  if (!$.active) {
    ajx.get(`/api/sales_orders/${salesOrderSelected}`)
    .then((res) => {
      sessionStorage.setItem('transaction_lines', JSON.stringify(res.sales_order.transaction_lines));
      $('#order_type').val(res.sales_order.order_type);
      $('#note').val(res.sales_order.note);
      $('#discount').val(res.sales_order.discount);
      $('#discount_amount').val(res.sales_order.discount_amount);
      $('#freight').val(res.sales_order.freight);
      $('#status_order').val(res.sales_order.order_type === 'general' ? 'open' : 'closed');
      $('#transaction_date').val(res.sales_order.transaction_date);
      $('#pickup_date').val(res.sales_order.pickup_date);
      $('#due_date').val(res.sales_order.due_date);
      $('#customer_id').val(res.sales_order.customer_id);
      $('#outlet').val(res.sales_order.agent_id);

      getDataTableSO(res.sales_order.customer_id, true);
      $('#customer_id, #outlet').select2({
        theme: 'bootstrap',
        placeholder: 'Choose option',
      }).trigger('change');
    })
    .catch(res => console.log(res));
  }
})

const getDataTableSO = (id, isEditable) => {
  ajx.get(`/api/customers/${id}`).then((res) => {
    ajx.get(`/api/prices/${res.customer.price_id}`).then((res) => {
      const prices = res.price.price_lines;
      sessionStorage.setItem('prices', JSON.stringify(prices));
      createTableSO(tableSOItems, prices, isEditable);
    }).catch(res => console.log(res));
  }).catch(res => console.log(res));
}

const createTableSO = (target, data, isEditable) => {
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
          return `<select class="form-control select2 item_id" id="item_id_${row.item_id}" data-id="${row.item_id}" name="item_id" required disabled><option></option></select>`;
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control" id="bor_${row.item_id}" data-id="${row.item_id}" name="bor" readonly>`
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control" id="note_${row.item_id}" data-id="${row.item_id}" name="note" readonly>`
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control quantity text-right" id="quantity_${row.item_id}" data-id="${row.item_id}" value="0" name="quantity" readonly>`
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control discount text-right" id="discount_${row.item_id}" data-id="${row.item_id}" value="0" name="discount" readonly>`
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
    drawCallback: (settings) => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
      createItemListDropdown(isEditable);
      // chooseCustomer();
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

const createItemListDropdown = (isEditable) => {
  const items = JSON.parse(sessionStorage.prices);
  for (let item of items) {
    const option = document.createElement('option');
    ajx.get(`/api/items/${item.item_id}`).then((res) => {
      option.value = item.item_id;
      option.textContent = `${res.item.description}`;
      $('.item_id').append(option);
      if (isEditable) {
        const transaction_lines = JSON.parse(sessionStorage.transaction_lines);
        transaction_lines.forEach((res, resIndex) => {
          const id = res.item_id;
          $('.item_id').each((index, item) => {
            if (resIndex === index) {
              item.value = id;
              item.parentElement.parentElement.querySelector('input[name="note"]').value = res.note;
              item.parentElement.parentElement.querySelector('input[name="bor"]').value = res.bor;
              item.parentElement.parentElement.querySelector('input[name="quantity"]').value = parseFloat(res.quantity).toFixed(0);
              item.parentElement.parentElement.querySelector('input[name="unit_price"]').value = parseFloat(res.unit_price).toFixed(0);
              item.parentElement.parentElement.querySelector('input[name="discount"]').value = parseFloat(res.discount).toFixed(0);
              item.parentElement.parentElement.querySelector('input[name="amount"]').value = parseFloat(res.amount).toFixed(0);
            }
          })
          totalBeforeDisc();
        })
      }
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


const dataFormSalesOrder = () => {
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
        bor: target.querySelector('input[name="bor"]').value,
        quantity: target.querySelector('input[name="quantity"]').value,
        unit_price: unit_price,
        discount: target.querySelector('input[name="discount"]').value,
        amount: amount,
        discount_amount: discount_amount
      })
    }
  })

  return {
    customer_id: $('#customer_id').val(),
    agent_id: $('#outlet').val(),
    transaction_date: $('#transaction_date').val(),
    pickup_date: $('#pickup_date').val(),
    delivery_date: $('#delivery_date').val(),
    due_date: $('#due_date').val(),
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
};

if (formCreateSalesInvoice.length > 0) {
  sessionStorage.clear();
  $('#button-delete').remove();
  formCreateSalesInvoice.submit((e) => {
    e.preventDefault();
    const data = dataFormSalesOrder();
    ajx.post('/api/sales_invoices', data).then(res => window.location = '/sales_invoices').catch(res => console.log(res));
    return false;
  })
}

if (formEditSalesInvoice.length > 0) {
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/sales_invoices/${id}`)
    .then(res => {
      sessionStorage.setItem('transaction_lines', JSON.stringify(res.sales_invoice.transaction_lines));
      $('#sales_order_id').val(res.sales_invoice.transaction_lines[0].transaction_id)
      $('#order_type').val(res.sales_invoice.order_type);
      $('#note').val(res.sales_invoice.note);
      $('#discount').val(res.sales_invoice.discount);
      $('#discount_amount').val(res.sales_invoice.discount_amount);
      $('#freight').val(res.sales_invoice.freight);
      $('#status_order').val(res.sales_invoice.order_type === 'general' ? 'open' : 'closed');
      $('#transaction_date').val(res.sales_invoice.transaction_date);
      $('#pickup_date').val(res.sales_invoice.pickup_date);
      $('#delivery_date').val(res.sales_invoice.delivery_date);
      $('#due_date').val(res.sales_invoice.due_date);
      $('#customer_id').val(res.sales_invoice.customer_id);
      $('#outlet').val(res.sales_invoice.agent_id);

      getDataTableSO(res.sales_invoice.customer_id, true);
      $('#customer_id, #outlet, #sales_order_id').select2({
        theme: 'bootstrap',
        placeholder: 'Choose option',
      }).trigger('change');
    })
    .catch(res => console.log(res));

  formEditSalesInvoice.submit((e) => {
    e.preventDefault();
    const data = dataFormSalesOrder();
    ajx.put(`/api/sales_invoices/${id}`, data).then(res => window.location = '/sales_invoices').catch(res => console.log(res));
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/sales_invoices/${id}`).then(res => window.location = '/sales_invoices').catch(res => {
      alert(res.responseJSON.message)
    });
  })
}
