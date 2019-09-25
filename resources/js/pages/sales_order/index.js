import ajx from './../../shared/index.js';

let transaction_lines = [];
let rowId = 0;
let currentTimeStamp;

const customerList = $('#customer_id');
const statusOrder = $('#status_order');
const orderType = $('#order_type');
const outletList = $('#agent_id');
const modalCustomerFormTable = $('#modal-customer-form-table');
const modalPriceFormTable = $('#modal-price-form-table');
const modalCustomerForm = $('#modal-customer-form');
const modalPriceForm = $('#modal-price-form');
const tableSOItems = $('#table-so-item');
const formCreateSalesOrder = $('#form-create-sales-order');
const formEditSalesOrder = $('#form-edit-sales-order');
const tableSalesOrder = $('#table-sales-order');

const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: true,
    pageLength: 5,
    columns: [
      { data: 'transaction_number' },
      { data: 'customer.name' },
      { data: 'agent.name' },
      { data: 'transaction_status' },
      { data: 'pickup_status' },
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

const createTableCustomerFormTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: true,
    pageLength: 10,
    columns: [
      {
        data: 'id',
        render(data, type, row) {
          return `<input type="radio" name="customer_id_radio" class="check-customer" value="${data}" price-id="${row.price_id}" customer-name="${row.name}" required/>`
        }
      },
      { data: 'id' },
      { data: 'name' },
      { 
        data: 'shipping_address',
        render(data, type, row) {
          return `${data.description}, ${data.district}, ${data.city}, ${data.country} ${data.zip_code}`
        }
      },
      { data: 'phone_number' },
      { 
        data: 'id',
        render(data) {
          return '';
        }
      },
    ],
    drawCallback: () => {
      $('.check-customer').change((e) => {
        const price_id = e.target.getAttribute('price-id');
        const name = e.target.getAttribute('customer-name');
        const customer_id = e.target.value;
        sessionStorage.setItem('choosed_customer', JSON.stringify({ customer_id: customer_id, name: name, price_id: price_id }));
        modalPriceFormTable.DataTable().destroy();
        tableSOItems.DataTable().destroy();
        generateItemTable(tableSOItems, []);
        getPriceList(price_id);
      });
    }
  })
};

const createTablePriceFormTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: true,
    pageLength: 10,
    columns: [
      {
        data: 'item_id',
        render(data, type, row) {
          rowId += 1;
          return `<input type="checkbox" name="item_id_radio" class="check-item" value="${data}" price-id="${row.price_id}" price-name="${row.item.description}" price-amount="${row.amount}" />`
        }
      },
      { data: 'item_id' },
      { data: 'item.description' },
      { data: 'amount' },
      { 
        data: 'id',
        render(data) {
          return '';
        }
      },
    ],
    drawCallback: () => {     
      $('.check-item').change((e) => {
        let datas = JSON.parse(sessionStorage.choosed_item);
        let choosed_id = datas.length > 0 ? datas[datas.length - 1].id : 0;
        const price_id = e.currentTarget.getAttribute('price-id');
        const name = e.currentTarget.getAttribute('price-name');
        const amount = e.currentTarget.getAttribute('price-amount');
        const item_id = e.currentTarget.value;
        if (e.currentTarget.checked && e.timeStamp !== currentTimeStamp) {
          currentTimeStamp = e.timeStamp;
          choosed_id += 1;
          e.currentTarget.setAttribute('clicked', choosed_id);
          datas.push({
            id: choosed_id,
            "item_id": item_id,
            "price_id": price_id,
            name: name,
            amount: amount,
          });
        } else if (e.currentTarget.checked === false){
          const id = e.currentTarget.getAttribute('clicked');
          datas = datas.filter(res => res.id !== parseFloat(id));
        }
        sessionStorage.setItem('choosed_item', JSON.stringify(datas));
        return false;
      });
    }
  })
};

const errorMessage = (data) => {
  Object.keys(data).map(key => {
    const $parent = $(`#${key}`).closest('.form-group');
    $parent.addClass('is-error');
    $parent[0].querySelector('.invalid-feedback').innerText = data[key][0];
  });
};

const generateItemTable = (target, data) => {
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
        data: 'name',
        render(data, type, row) {
          return `<input type="text" class="form-control item_id" id="item_id_${row.id}" data-id="${row.item_id}" name="item_id" readonly value="${data}" ${row.status ? 'line-id="updated"' : ''}}>`
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control" id="bor_${row.id}" data-id="${row.item_id}" value="${row.bor ? row.bor : ''}" name="bor" required>`
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return `<select class="form-control brand_id" id="brand_id_${row.id}" data-id="${row.item_id}" name="brand_id" required value="${row.brand_id}"></select>`;
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control" id="color_${row.id}" data-id="${row.item_id}" name="color" value="${row.color ? row.color : ''}">`
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control" id="note_${row.id}" data-id="${row.item_id}" name="note" value="${row.note ? row.note  : ''}">`
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control quantity text-right is-number" id="quantity_${row.id}" data-id="${row.item_id}" value="1" name="quantity">`
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control discount text-right is-number" id="discount_${row.id}" data-id="${row.item_id}" value="0" name="discount">`
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          const val = Number.parseFloat(row.amount);
          return `<div class="input-group flex-nowrap">
            <div class="input-group-prepend">
                <span class="input-group-text">Rp</span>
            </div>
            <input type="text" class="form-control text-right is-number" id="unit_price_${row.id}" data-id="${row.item_id}" name="unit_price" value="${val}" readonly>
          </div>`
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          const val = Number.parseFloat(row.amount);
          return `<div class="input-group flex-nowrap">
          <div class="input-group-prepend">
              <span class="input-group-text">Rp</span>
          </div>
          <input type="text" class="form-control text-right item_total is-number" id="amount_${row.id}" data-id="${row.item_id}" name="amount" value="${val}" readonly>
      </div>`
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          const del = `<a href="javascript:void(0)" id="delete_${data}" data-id="${row.item_id}" class="btn btn-light is-small table-action remove-item" data-toggle="tooltip"
          data-placement="top" title="Reset"><img src="${window.location.origin}/assets/images/icons/trash.svg" alt="edit" width="16"></a>`;
          
          const status = `<input id="status_${row.id}" class="form-control" name="status" readonly value="${row.status}" style="display: inline-block; width: 100px; vertical-align: middle;" />`;
          const buttonCancel = `<button id="cancel_${row.id}" type="button" class="btn btn-light mx-2 auto-button" style="display: inline-block; vertical-align: middle; top: 0;">Cancel</button>`;
          const buttonPicked = `<button id="picked_${row.id}" type="button" class="btn btn-primary m-0 auto-button" style="display: inline-block; vertical-align: middle;">Picked</button>`;
          return row.status ? status + buttonCancel + buttonPicked : del;
        },
      },
    ],
    drawCallback: () => {
      getBrandList();
      $('.table-responsive').addClass('adjust-width');
      removeItem();
      totalBeforeDisc();
      updateDiscountAndQuantity();
      $('.auto-button').click(e => {
        const value = e.target.id.split('_')[0];
        const id = e.target.id.split('_')[1];
        if (value === 'cancel') {
          $(`#status_${id}`).val('canceled');
          $(`#amount_${id}`).val(0);
          totalBeforeDisc();
        } else {
          const qty = parseFloat($(`#quantity_${id}`).val());
          const itm = parseFloat($(`#unit_price_${id}`).val());
          $(`#amount_${id}`).val(qty * itm);
          $(`#status_${id}`).val('done');
          totalBeforeDisc();
        }
      })
      $('.brand_id').each((i, item) => {
        item.value = item.getAttribute('value');
      })
    },
  })
};

const removeItem = () => {
  $('.remove-item').click((e) => {
    const choosed_item = JSON.parse(sessionStorage.choosed_item);
    const parent = e.target.closest('tr');
    const id = e.currentTarget.id.split('_')[1];
    const latest_choosed_item = choosed_item.filter(res => res.id !== parseFloat(id));
    sessionStorage.setItem('choosed_item', JSON.stringify(latest_choosed_item));
    tableSOItems.DataTable().row([parent]).remove().draw();
    totalBeforeDisc();
    if ($('.remove-item').length === 0) {
      $('#original_amount').val(0);
      $('#discount').val(0);
      $('#discount_amount').val(0);
      $('#freight').val(0);
      $('#total_amount').val(0);
    }
  });
};

const getPriceList = (id) => {
  ajx.get(`/api/prices/${id}`).then((res) => {
    const prices = res.price.price_lines;
    sessionStorage.setItem('prices', JSON.stringify(prices));
    createTablePriceFormTable(modalPriceFormTable, prices);
  }).catch(res => console.log(res));
}

const getBrandList = () => {
  if (sessionStorage.brands !== undefined) {
    const brands = JSON.parse(sessionStorage.brands);
    if (!$('.brand_id').hasClass('has-updated')) {
      for (let brand of brands) {
        const option = document.createElement('option');
        option.value = brand.id;
        option.textContent = `${brand.name}`;
        $('.brand_id').append(option);   
      }
      $('.brand_id').addClass('has-updated');
    }
  }
}

const updateDiscountAndQuantity = () => {
  $('.discount, .quantity').change((e) => {
    e.target.value = e.target.value === '' ? 0 : e.target.value;
    const id = e.target.id.split('_')[1];
    const itemQuantity = $(`#quantity_${id}`).val();
    const itemPrice = $(`#unit_price_${id}`).val();
    const discPrice = $(`#discount_${id}`).val();
    const countItemPrice = parseFloat(itemPrice) * parseFloat(itemQuantity);
    const calculate = discPrice !== '0' && itemQuantity !== '0' ? parseFloat(countItemPrice) - (parseFloat(discPrice)/100 * parseFloat(countItemPrice)): parseFloat(countItemPrice);
    $(`#amount_${id}`).val(parseFloat(calculate));
    totalBeforeDisc();
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
  updateDiscountAndQuantity();
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

const dataFormSalesOrder = () => {
  transaction_lines = [];
  $('.item_id').each((i, item) => {
    const discount_amount = item.parentElement.parentElement.querySelector('input[name="unit_price"]').value - item.parentElement.parentElement.querySelector('input[name="amount"]').value;
    if ($(item).val() !== '') {
      const target = item.parentElement.parentElement;
      const unit_price = target.querySelector('input[name="unit_price"]').value;
      const amount = target.querySelector('input[name="amount"]').value;
      const discount_amount = parseFloat(unit_price) - parseFloat(amount);
      if (formEditSalesOrder.length > 0) {
        transaction_lines.push({
          id: item.hasAttribute('line-id') ? item.id.split('_')[2] : null,
          item_id: $(item).attr('data-id'),
          note: target.querySelector('input[name="note"]').value,
          bor: target.querySelector('input[name="bor"]').value,
          brand_id: target.querySelector('select[name="brand_id"]').value,
          color: target.querySelector('input[name="color"]').value,
          quantity: target.querySelector('input[name="quantity"]').value,
          unit_price: unit_price,
          discount: target.querySelector('input[name="discount"]').value,
          amount: amount,
          discount_amount: discount_amount,
          status: target.querySelector('input[name="status"]') ? target.querySelector('input[name="status"]').value : 'open',
        })
      } else {
        transaction_lines.push({
          item_id: $(item).attr('data-id'),
          note: target.querySelector('input[name="note"]').value,
          bor: target.querySelector('input[name="bor"]').value,
          brand_id: target.querySelector('select[name="brand_id"]').value,
          color: target.querySelector('input[name="color"]').value,
          quantity: target.querySelector('input[name="quantity"]').value,
          unit_price: unit_price,
          discount: target.querySelector('input[name="discount"]').value,
          amount: amount,
          discount_amount: discount_amount,
        })
      }
    }
  })

  return {
    is_own_address: $('#is_own_address').prop('checked'),
    customer_id: $('#customer_id').attr('customer-id'),
    agent_id: $('#agent_id').val(),
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
};

if (modalCustomerForm.length > 0) {
  ajx.get('/api/customers').then((res) => {
    const customers = res.customers.data;
    createTableCustomerFormTable(modalCustomerFormTable, customers);
  }).catch(res => console.log(res));

  modalCustomerForm.submit((e) => {
    e.preventDefault();
    const choosed_customer = JSON.parse(sessionStorage.choosed_customer);
    $('#modal-customer').modal('hide');
    $('#customer_id').val(choosed_customer.name);
    $('#customer_id').attr('customer-id', choosed_customer.customer_id);
    $('#btn-add-item').attr('disabled', false);
    $('#btn-add-item').removeClass('disabled');
    return false;
  });
}

if (modalPriceForm.length > 0) {
  modalPriceForm.submit((e) => {
    e.preventDefault();
    const choosed_item = JSON.parse(sessionStorage.choosed_item);
    const prices = JSON.parse(sessionStorage.prices);
    generateItemTable(tableSOItems, choosed_item);
    $('#modal-price').modal('hide');
    modalPriceFormTable.DataTable().destroy();
    createTablePriceFormTable(modalPriceFormTable, prices);
    return false;
  });
}

if (outletList.length > 0) {
  ajx.get('/api/brands').then((res) => {
    const brands = res.brands.data;
    sessionStorage.setItem('brands', JSON.stringify(brands));
  }).catch(res => console.log(res));
  
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
  sessionStorage.clear();
  sessionStorage.setItem('choosed_item', '[]');
  $('#button-delete').remove();
  formCreateSalesOrder.submit((e) => {
    e.preventDefault();
    $('#form-submit').attr('disabled', true);
    const data = dataFormSalesOrder();
    ajx.post('/api/sales_orders', data).then(res => window.location = '/sales_orders').catch(res => {
      const errors = res.responseJSON.errors;      
      errorMessage(errors);
      console.log(res)
      $('#form-submit').attr('disabled', false);
    });
    return false;
  })
}

if (tableSalesOrder.length > 0) {
  sessionStorage.clear();
  ajx.get('/api/sales_orders').then((res) => {
    createTable(tableSalesOrder, res.sales_orders.data);
  }).catch(res => console.log(res));
}

if (formEditSalesOrder.length > 0) {
  sessionStorage.clear();
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  $('#agent_id').removeClass('select2');
  $('#agent_id').attr('disabled', true);
  ajx.get(`/api/sales_orders/${id}`)
    .then((res) => {
      const choosed_item = [];
      let id = 0;
      res.sales_order.transaction_lines.forEach(res => {
        id = res.id ? res.id : id + 1;
        choosed_item.push({
          id: id,
          "item_id": res.item_id,
          "brand_id": res.brand_id,
          "bor": res.bor,
          "price_id": res.item.price_id,
          "unit_price": res.unit_price,
          discount: res.discount,
          quantity: res.quantity,
          color: res.color,
          note: res.note,
          name: res.item.description,
          amount: res.amount,
          status: res.status,
        });
      });
      
      sessionStorage.setItem('choosed_item', JSON.stringify(choosed_item));
      generateItemTable(tableSOItems, choosed_item);
      $('#customer_id').attr('customer-id',res.sales_order.customer_id);
      $('#customer_id').val(res.sales_order.customer.name);
      $('#agent_id').val(res.sales_order.agent_id);
      $('#agent_id').attr('readonly', true);
      $('#is_own_address').attr('readonly', true);
      $('#is_own_address').attr('disabled', true);
      $('#is_own_address').attr('checked', res.sales_order.is_own_address);
      $('#order_type').val(res.sales_order.order_type);
      $('#note').val(res.sales_order.note);
      $('#discount').val(res.sales_order.discount);
      $('#discount_amount').val(res.sales_order.discount_amount);
      $('#freight').val(res.sales_order.freight);
      $('#status_order').val(res.sales_order.order_type === 'general' ? 'open' : 'closed');
      $('#original_amount').val(res.sales_order.original_amount);
      $('#total_amount').val(res.sales_order.total_amount);
      $('#transaction_date').val(res.sales_order.transaction_date);
      $('#pickup_date').val(res.sales_order.pickup_date);
      $('#delivery_date').val(res.sales_order.delivery_date);
      getPriceList(res.sales_order.customer.price_id);
      $('#btn-add-item').attr('disabled', res.sales_order.transaction_status === 'canceled');
      $('#btn-add-item').removeClass(res.sales_order.transaction_status === 'canceled' ? '' : 'disabled');
    })
    .catch(res => console.log(res));

  formEditSalesOrder.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const data = dataFormSalesOrder();
    ajx.put(`/api/sales_orders/${id}`, data).then(res => window.location = '/sales_orders').catch(res => {
      const errors = res.responseJSON.errors;      
      errorMessage(errors);
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/sales_orders/${id}`).then(res => window.location = '/sales_orders').catch(res => {
      alert(res.responseJSON.error_messages);
    });
  })
}