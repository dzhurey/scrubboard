import ajx from './../../shared/index.js';

const tablePayment = $('#table-payment');
const formCreatePayment = $('#form-create-payment');
const salesInvoicePayment = $('#payment-sales-invoice-id');
const paymentMethod = $('#payment_method');
const bankAccount = $('#bank_account');
const modalSIpayment = $('#modal-si-form-payment');
const modalSITable = $('#modal-si-form-table-payment');
const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: true,
    lengthMenu: [ 15, 25, 50, 100 ],
    searching: true,
    info: true,
    paging: true,
    pageLength: 15,
    order: [[3, 'desc']],
    columns: [
      { data: 'payment_code' },
      { data: 'payment_lines[0].transaction.transaction_number' },
      { data: 'customer.name' },
      { data: 'payment_date' },
      { data: 'payment_lines[0].transaction.transaction_status' },
      {
        data: 'payment_means[0].payment_type',
        render(h) {
          return h === "" ? "-" : h;
        },
      },
      { data: 'total_amount' },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};

const createSiFormTablePayment = (target, data) => {
  target.DataTable({
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
          return `<input type="radio" name="invoice_id" class="check-item" value="${data}" />`;
        },
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
        data: 'total_amount',
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
        const id = e.target.value;
        if (e.target.checked) {
          ajx.get(`/api/sales_invoices/${id}`)
            .then((res) => {
              sessionStorage.setItem('choosed_si', JSON.stringify(res.sales_invoice));
            })
        }
      });
    }
  });
};

if (modalSIpayment.length > 0) {
  modalSIpayment.submit((e) => {
    e.preventDefault();
    const choosed_si = JSON.parse(sessionStorage.choosed_si);
    modalSITable.DataTable().destroy();
    createSiFormTablePayment(modalSITable, choosed_si);
    $('#modal-sales-invoices-payment').modal('hide');
    $('.check-item').each((i, item) => {
      item.checked = false;
    })
    $('#customer-name').val(choosed_si.customer.name);
    $('#customer-name').attr('customer-id', choosed_si.customer.id);
    $('#transaction_type').val(choosed_si.transaction_type);
    $('#total-amount').val(choosed_si.total_amount);
    $('#amount').val(choosed_si.total_amount);
    $('#payment-sales-invoice-id').val(choosed_si.transaction_number);
    $('#payment-sales-invoice-id').attr('data-id', choosed_si.id);
    return false;
  });
}

if (salesInvoicePayment.length > 0) {
  ajx.get('/api/sales_invoices?filter[]=transaction_status,!=,closed').then((res) => {
    createSiFormTablePayment(modalSITable, res.sales_invoices.data);
  }).catch(res => console.log(res));
}

if (bankAccount.length > 0) {
  ajx.get('/api/bank_accounts').then((res) => {
    sessionStorage.setItem('bank_accounts', JSON.stringify(res.bank_accounts.data));
    for (let item of res.bank_accounts.data) {
      const option = document.createElement('option');
      option.value = item.id;
      option.textContent = `${item.bank.name} - ${item.account_number}`;
      bankAccount.append(option);
    }
  }).catch(res => console.log(res));
}

if (paymentMethod.length > 0) {
  $('#field-transfer').hide();
  $('#field-credit-card').hide();
  paymentMethod.change((e) => {
    if (e.target.value === 'bank_transfer') {
      $('#field-credit-card').hide();
      $('#field-transfer').show();
    } else if (e.target.value === 'credit_card') {
      $('#field-transfer').hide();
      $('#field-credit-card').show();
    } else {
      $('#field-transfer').hide();
      $('#field-credit-card').hide();
    }
  })
}

if (formCreatePayment.length > 0) {
  $('#button-delete').remove();
  formCreatePayment.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    ajx.post('/api/payments', {
      "customer_id" : $('#customer-name').attr('customer-id'),
      "payment_date" : $('#date').val(),
      "payment_type" : $('#payment_method').val(),
      "transaction_id" : $('#payment-sales-invoice-id').attr('data-id'),
      "bank_account_id" : $('#bank_account').val(),
      "note" : $('#note').val(),
      "bank_id": $('select[name="bank_id"]').val(),
      "amount" : $('#total-amount').val(),
      "total_amount" : $('#total-amount').val(),
    }).then(res => {
      window.location = '/payments'
    }).catch(res => {
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })
}

if (tablePayment.length > 0) {
  ajx.get('/api/payments').then((res) => {
    createTable(tablePayment, res.payments.data);
  }).catch(res => console.log(res));
}