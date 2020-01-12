import ajx from './../../shared/index.js';
import printJS from 'print-js';

let transaction_lines = [];

const tableInvoice = $('#table-sales-invoice');
const salesOrderFormCreateInvoice = $('#modal-sales-order-on-invoice-form-table');
const salesOrderFormInvoice = $('#modal-sales-order-on-invoice-form');
const modalSalesOrderInvoice = $('#modal-sales-order-on-invoice');
const tableSOItems = $('#table-so-item');
const formCreateSalesInvoice = $('#form-create-sales-invoice');
const formEditSalesInvoice = $('#form-edit-sales-invoice');

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
      { data: 'transaction_number' },
      { data: 'customer.name' },
      { data: 'agent.name' },
      { data: 'transaction_status' },
      { data: 'delivery_status' },
      { data: 'transaction_date' },
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
const createInvoiceTableSO = (target, data) => {
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
          return `<input type="radio" name="transaction_id" class="check-so" value="${data}" transaction-number="${row.transaction_number}" />`;
        },
      },
      { data: 'transaction_number' },
      { data: 'customer.name' },
      { data: 'agent.name' },
      { data: 'transaction_status' },
      { data: 'transaction_date' },
      {
        data: 'total_amount',
        render(data) {
          return parseFloat(data).toFixed(0)
        }
      },
      {
        data: 'id',
        render() {
          return ''
        }
      }
    ],
    drawCallback: () => {
      $('.check-so').change((e) => {
        const transaction_id = e.target.value;
        const transaction_number = e.target.getAttribute('transaction-number');
        sessionStorage.setItem('choosed_so', JSON.stringify({ transaction_id: transaction_id, transaction_number: transaction_number }));
      });
    }
  });
};

const generateItemTable = (target, data) => {
  target.DataTable({
    // scrollX: true,
    destroy: true,
    data: data,
    lengthChange: false,
    lengthMenu: [ 15, 25, 50, 100 ],
    searching: false,
    info: false,
    paginate: false,
    pageLength: 15,
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
          return `<input type="text" class="form-control" id="bor_${row.id}" value="${row.bor}" name="bor" required readonly>`
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<input class="form-control brand_id" id="brand_id_${row.id}" name="brand_id" required readonly brand-id="${row.brand_id}" value="${row.brand_name}"/>`;
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control" id="color_${row.id}" name="color" required readonly value="${row.color ? row.color : ''}">`
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control" id="note_${row.id}" name="note" required readonly value="${row.note ? row.note : ''}">`
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control quantity text-right is-number" id="quantity_${row.id}" required readonly value="${row.quantity}" name="quantity">`
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<input type="text" class="form-control discount text-right is-number" id="discount_${row.id}" required readonly value="${row.discount}" name="discount">`
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<div class="input-group flex-nowrap">
          <div class="input-group-prepend">
              <span class="input-group-text">Rp</span>
          </div><input type="text" class="form-control text-right is-number" id="unit_price_${row.id}" name="unit_price" value="${row.amount}" readonly></div`
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<div class="input-group flex-nowrap">
          <div class="input-group-prepend">
              <span class="input-group-text">Rp</span>
          </div><input type="text" class="form-control text-right item_total is-number" id="amount_${row.id}" name="amount" value="${row.amount}" readonly></div>`
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return row.status;
        },
      },
    ],
    drawCallback: () => {
      $('.table-responsive').addClass('adjust-width');
      totalBeforeDisc();
      updateDiscountAndQuantity();
    },
  })
};

const getDetailSalesOrder = (url, key, id) => {
  ajx.get(`/api/${url}/${id}`)
  .then((res) => {
    $('#order_id').val(res[key].transaction_number);
    $('#order_type').val(res[key].order_type);
    $('#customer_id').val(res[key].customer.name);
    $('#customer_id').attr('customer-id', res[key].customer_id);
    $('#agent_outlet').val(res[key].agent.name);
    $('#agent_outlet').attr('agent-id', res[key].agent_id);
    $('#status_order').val(res[key].order_type === 'general' ? 'open' : 'closed');
    $('#note').val(res[key].note);
    $('#pickup_date').val(res[key].pickup_date);
    $('#dp_amount').val(res[key].dp_amount ? parseFloat(res[key].dp_amount) : '0');
    $('#dp_amount_print').val(res[key].dp_amount ? parseFloat(res[key].dp_amount) : '0');
    $('#is_own_address').attr('checked', res[key].is_own_address);
    $('#freight').val(parseFloat(res[key].freight));
    $('#freight_print').val(parseFloat(res[key].freight));
    const choosed_item = [];
    let id = 0;
    res[key].transaction_lines.forEach(res => {
      id = res.id ? res.id : id + 1;
      if (res.status !== 'canceled') {
        choosed_item.push({
          id: id,
          "item_id": res.item_id,
          "brand_id": res.brand_id,
          "brand_name": res.brand.name,
          "bor": res.bor,
          "price_id": res.item.price_id,
          "unit_price": res.unit_price,
          discount: parseFloat(res.discount),
          quantity: parseFloat(res.quantity),
          color: res.color,
          note: res.note,
          name: res.item.description,
          amount: parseFloat(res.amount),
          status: res.status,
        });
      }
    });
    sessionStorage.setItem('choosed_item', JSON.stringify(choosed_item));
    generateItemTable(tableSOItems, choosed_item);
  })
  .catch(res => console.log(res));
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
    $('#original_amount_print').val(price);
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
  $('#discount_amount_print').val(parseFloat(discountCount));
  const freight = freightValue ? freightValue : $('#freight').val();
  const total = parseFloat(original_amount) - parseFloat(discount.val()) + parseFloat(freight);
  $('#total_amount').val(parseFloat(total));
  $('#total_amount_print').val(parseFloat(total));
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
      transaction_lines.push({
        id: item.hasAttribute('line-id') ? item.id.split('_')[2] : null,
        item_id: $(item).attr('data-id'),
        note: target.querySelector('input[name="note"]').value,
        bor: target.querySelector('input[name="bor"]').value,
        brand_id: target.querySelector('input[name="brand_id"]').getAttribute('brand-id'),
        color: target.querySelector('input[name="color"]').value,
        quantity: target.querySelector('input[name="quantity"]').value,
        unit_price: unit_price,
        discount: target.querySelector('input[name="discount"]').value,
        amount: amount,
        discount_amount: discount_amount,
        status: target.querySelector('input[name="status"]') ? target.querySelector('select[name="status"]').value : 'open',
      })
    }
  })

  return {
    is_own_address: $('#is_own_address').prop('checked'),
    order_id: $('#order_id').attr('order-id'),
    customer_id: $('#customer_id').attr('customer-id'),
    agent_id: $('#agent_outlet').attr('agent-id'),
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
    dp_amount: $('#dp_amount').val(),
    transaction_lines: transaction_lines,
    promo_id: null, // TO DO
  }
};

const errorMessage = (data) => {
  Object.keys(data).map(key => {
    const $parent = $(`#${key}`).closest('.form-group');
    $parent.addClass('is-error');
    $parent[0].querySelector('.invalid-feedback').innerText = data[key][0];
  });
};

if (salesOrderFormInvoice.length > 0) {
  sessionStorage.clear();
  ajx.get('/api/sales_orders?filter[]=transaction_status,=,open&filter[]=pickup_status,=,done').then((res) => {
    createInvoiceTableSO(salesOrderFormCreateInvoice, res.sales_orders.data);
  }).catch(res => console.log(res));

  salesOrderFormInvoice.submit((e) => {
    e.preventDefault();
    const choosed_so = JSON.parse(sessionStorage.choosed_so);
    modalSalesOrderInvoice.modal('hide');
    $('#order_id').attr('order-id', choosed_so.transaction_id);
    $('#order_id').val(choosed_so.transaction_number);
    getDetailSalesOrder('sales_orders', 'sales_order', choosed_so.transaction_id);
    return false;
  });
}

if (formCreateSalesInvoice.length > 0) {
  sessionStorage.clear();
  $('#button-delete').remove();
  formCreateSalesInvoice.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const data = dataFormSalesOrder();
    ajx.post('/api/sales_invoices', data).then(res => window.location = '/sales_invoices').catch(res => {
      const errors = res.responseJSON.errors;
      errorMessage(errors);
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })
}

if (tableInvoice.length > 0) {
  ajx.get('/api/sales_invoices').then((res) => {
    createTable(tableInvoice, res.sales_invoices.data);
  }).catch(res => console.log(res));
}

if (formEditSalesInvoice.length > 0) {
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  $('.btn[data-target="#modal-sales-order-on-invoice"]').remove();
  $('label[for="order_id"]').text('No. Invoice');
  $('#dp_amount').attr('readonly', true);
  $('#footer-form').remove();
  $('#due_date, #transaction_date, #discount, #freight, #is_own_address').attr('readonly', true);
  getDetailSalesOrder('sales_invoices', 'sales_invoice', id);
}

$('#btn-print').click(() => {
  // window.print();
  const stylePrintJS = `
    @page :left {
      margin-left: 5mm;
    }    
    @page :right {
      margin-left: 5mm;
    }
    @page {
      body {
        size: A6;
        width: 100% !important;
        margin: 0 !important;
      }
    }
    .c-sidebar,
    .c-header,
    #customers-form,
    #pickup-outlet,
    #pos-outlet,
    #inv-data #pickup-date.col-sm-6,
    #status--order,
    #delivery--date,
    .btn,
    .c-form--title,
    #inv-data .col-sm-2,
    .c-table--outer table tr th:nth-child(2),
    .c-table--outer table tr th:nth-child(3),
    .c-table--outer table tr th:nth-child(4),
    .c-table--outer table tr th:nth-child(5),
    .c-table--outer table tr th:nth-child(7),
    .c-table--outer table tr th:last-child,
    .c-table--outer table tr td:nth-child(2),
    .c-table--outer table tr td:nth-child(3),
    .c-table--outer table tr td:nth-child(4),
    .c-table--outer table tr td:nth-child(5),
    .c-table--outer table tr td:nth-child(7),
    .c-table--outer table tr td:last-child,
    #foot-note,
    #discount-percent,
    hr {
      display: none !important;
    }
    .main {
      max-width: 100% !important;
      padding-left: 0 !important;
      margin-top: 0 !important;
    }
    #form-edit-sales-invoice,
    #form-create-sales-invoice {
      box-shadow: none !important;
      margin: 0 !important;
      padding: 0 !important;
    }
    .form-control {
      border: 0 !important;
      padding: 0 !important;
    }
    label,
    .c-table--outer.mx-0 {
      margin: 0 !important;
    }
    label span {
      display: none !important;
    }
    .c-form--label {
      width: 100% !important;
      font-size: 12pt !important;
      font-weight: 800 !important;
    }
    .form-control {
      max-width: 100% !important;
      font-size: 14pt !important;
      text-transform: capitalize !important;
      line-height: normal !important;
      white-space: nowrap !important;
      overflow: hidden !important;
      text-overflow: ellipsis !important;
    }
    #order_id {
      width: 100% !important;
      font-size: 21pt !important;
      font-weight: 800 !important;
    }
    #table-so-item {
      width: 100% !important;
    }
    #inv-data .col-sm-4 {
      display: inline-block !important;
      width: 50% !important;
    }
    #inv-data > .col-sm-6 {
      display: inline-block !important;
      width: 50% !important;
    }
    #inv-data #due--date {
      display: block !important;
      width: 100% !important;
      flex: 0 0 100% !important
    }
    .mb-4,
    .form-group {
      margin-bottom: 5px !important;
    }
    #logo-print,
    #total-count {
      display: block !important;
    }
    .c-table--outer,
    .c-table--outer .table-responsive {
      display: block;
      margin-top: -100px !important;
      width: 100% !important;
      overflow: visible !important;
      border: 0 !important;
    }
    .c-table--outer table tr td .form-control {
      font-size: 12pt !important;
    }
    .c-table--outer table tr td {
      padding: 5px 0 0 !important;
      overflow: hidden;
    }
    .c-table--outer table tr th:first-child,
    .c-table--outer table tr td:first-child {
      display: inline-block !important;
      width: 50% !important;
      padding-left: 0 !important;
    }
    .c-table--outer table tr td input.form-control {
      padding: 0 !important;
      line-height: 18px !important;
      height: 18px !important;
      margin: 0 !important;
      position: relative !important;
      bottom: -15px !important;
    }
    .c-table--outer table tr th:nth-child(6),
    .c-table--outer table tr td:nth-child(6),
    .c-table--outer table tr td:nth-child(6) input.form-control {
      display: inline-block !important;
      width: 10mm !important;
    }
    .c-table--outer table tr th:nth-child(8),
    .c-table--outer table tr td:nth-child(8),
    .c-table--outer table tr td:nth-child(8) .input-group,
    .c-table--outer table tr th:nth-child(9),
    .c-table--outer table tr td:nth-child(9),
    .c-table--outer table tr td:nth-child(9) .input-group {
      display: inline-block !important;
      width: 40mm !important;
      text-align: right !important:
      padding-right: 0 !important;
    }
    table {
      width: 100% !important;
      page-break-inside: avoid;
    }
    .c-table--outer table tr td .input-group {
      top: 15px !important;
      left: 15px !important;
    }
    .c-table--outer table tr td .input-group .input-group-prepend,
    #foot-note .input-group .input-group-prepend {
      border: 0 !important;
      display: none !important;
    }
    .c-table--outer .c-table.table tbody th:last-child
    .c-table--outer .c-table.table tbody td:last-child {
      padding-right: 0 !important;
    }
    #total-count {
      width: 50% !important;
      margin-left: 50% !important;
    }
    #total-count .form-control {
      text-align: right !important;
      width: 40mm !important;
      position: relative !important;
      left: -35px !important;
      top: -5px !important;
      font-size: 12pt !important;
    }
  `;
  const target = $('#form-edit-sales-invoice').length > 0 ? 'form-edit-sales-invoice' : 'form-create-sales-invoice';
  printJS({
    printable: target,
    type: 'html',
    style: stylePrintJS,
    targetStyles: ['*'],
  });
});