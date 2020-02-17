import ajx from './../../shared/index.js';

const tablePayment = $('#table-payment');
const formCreatePayment = $('#form-create-payment');
const formEditPayment = $('#form-edit-payment');
const salesInvoicePayment = $('#payment-sales-invoice-id');
const paymentMethod = $('#payment_method');
const bankAccount = $('#bank_account');
const modalSIpayment = $('#modal-si-form-payment');
const modalSITable = $('#modal-si-form-table-payment');
const formPaymentMeans = $('#modal-add-form-payment-means');
let paymentLines = [];
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
      { data: 'payment_code' },
      { data: 'payment_lines[0].transaction.transaction_number' },
      { data: 'customer.name' },
      { data: 'payment_date' },
      {
        data: 'transaction.balance_due',
        render(data, type, row) {
          return parseFloat(data) === 0  ? 'PAID' : 'UNPAID';
        },
      },
      { 
        data: 'transaction.balance_due',
        render(data) {
          return parseFloat(data);
        },
      },
      {
        data: 'transaction.total_amount',
        render(data) {
          return parseFloat(data);
        },
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="/payments/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
          data-placement="top" title="Edit"><img src="assets/images/icons/edit.svg" alt="edit" width="16"></a>`
        },
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};

const createSiFormTablePayment = (target, data) => {
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
        render(value) {
          return parseFloat(value);
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
    // $('#total_amount').val(parseFloat(choosed_si.balance_due));
    $('#total_amount').val(parseFloat(0));
    $('#amount').val(parseFloat(choosed_si.balance_due));
    $('#totalAmount').val(parseFloat(choosed_si.total_amount));
    $('#payment-sales-invoice-id').val(choosed_si.transaction_number);
    $('#payment-sales-invoice-id').attr('data-id', choosed_si.id);
    $('#add-payment-means').removeAttr('disabled');
    $('#add-payment-means').removeClass('disabled');
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
  sessionStorage.clear();
  $('#button-delete').remove();
  formCreatePayment.submit((e) => {
    e.preventDefault();
    const paymentLines = JSON.parse(sessionStorage.payment_lines)
    $('button[type="submit"]').attr('disabled', true);
    ajx.post('/api/payments', {
      "customer_id" : $('#customer-name').attr('customer-id'),
      "transaction_id" : $('#payment-sales-invoice-id').attr('data-id'),
      "note" : $('#note').val(),
      "total_amount" : paymentLines.reduce((agg, item) => agg += parseFloat(item.amount), 0),
      "payment_lines": paymentLines,
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

if (formEditPayment.length > 0) {
  sessionStorage.clear();
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/payments/${id}`).then(({payment}) => {
    sessionStorage.setItem('payment_lines', JSON.stringify(payment.payment_means));
    tablePaymentLines($('#table-payment-lines'), JSON.parse(sessionStorage.payment_lines));
    $('#button-choose-invoices').prop('disabled', true);
    ajx.get(`/api/sales_invoices/${payment.payment_lines[0].transaction.id}`)
      .then((res) => {
        sessionStorage.setItem('choosed_si', JSON.stringify(res.sales_invoice));
        const choosed_si = JSON.parse(sessionStorage.choosed_si);
        $('#customer-name').val(choosed_si.customer.name);
        $('#customer-name').attr('customer-id', choosed_si.customer.id);
        $('#transaction_type').val(choosed_si.transaction_type);
        // $('#total_amount').val(parseFloat(choosed_si.balance_due));
        $('#total_amount').val(parseFloat(0));
        $('#amount').val(parseFloat(choosed_si.balance_due));
        $('#totalAmount').val(parseFloat(choosed_si.total_amount));
        $('#payment-sales-invoice-id').val(choosed_si.transaction_number);
        $('#payment-sales-invoice-id').attr('data-id', choosed_si.id);
        $('#add-payment-means').removeAttr('disabled');
        $('#add-payment-means').removeClass('disabled');
      })
  }).catch(res => console.log(res));

  formEditPayment.submit((e) => {
    e.preventDefault();
    const paymentLines = JSON.parse(sessionStorage.payment_lines)
    $('button[type="submit"]').attr('disabled', true);
    ajx.put(`/api/payments/${id}`, {
      "customer_id" : $('#customer-name').attr('customer-id'),
      "transaction_id" : $('#payment-sales-invoice-id').attr('data-id'),
      "note" : $('#note').val(),
      "total_amount" : paymentLines.reduce((agg, item) => agg += parseFloat(item.amount), 0),
      "payment_lines": paymentLines,
    }).then(res => {
      window.location = '/payments'
    }).catch(res => {
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })
}

const tablePaymentLines = (target, data) => {
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
        data: 'payment_method',
        render(data, type, row) {
          let paymentMethod;
          if (data && data === 'cash') {
            paymentMethod = 'Cash';
          } else if (data && data === 'bank_transfer') {
            paymentMethod = 'Bank Transfer';
          } else if (data && data === 'credit_card') {
            paymentMethod = 'Credit Card';
          } else {
            paymentMethod = 'Bebemoney';
          }
          return `<input type="text" class="form-control" readonly value="${paymentMethod}"/>`
        }
      },
      {
        data: 'payment_type',
        render(data, type, row) {
          return `<input type="text" class="form-control" readonly value="${data && data === 'down_payment' ? 'Booking Fee' : 'Acquittance'}"/>`
        }
      },
      {
        data: 'bank_account_id',
        render(data, type, row) {
          let name;
          let account_number;
          if (data) {
            const parsing = JSON.parse(sessionStorage.bank_accounts).filter(res => res.id === parseInt(data))[0];
            name = parsing.bank.name;
            account_number = parsing.account_number;
          }
          return `<input hidden type="text" class="form-control" readonly value="${data ? data : ''}"/><input type="text" class="form-control" readonly value="${data ? name + ' - ' + account_number : ''}"/>`
        }
      },
      {
        data: 'receiver_name',
        render(data, type, row) {
          return `<input type="text" class="form-control" readonly value="${data ? data : ''}"/>`
        }
      },
      {
        data: 'credit_card_no',
        render(data, type, row) {
          return `<input type="text" class="form-control" readonly value="${data ? data : ''}"/>`
        }
      },
      {
        data: 'bank_id',
        render(data, type, row) {
          const bank = row.bank ? row.bank.name : row.bank_name;
          return `<input hidden type="text" class="form-control" readonly value="${data && row.payment_method === 'credit_card' ? data : ''}"/><input type="text" class="form-control" readonly value="${row && row.payment_method === 'credit_card' ? bank : ''}"/>`
        }
      },
      {
        data: 'amount',
        render(data, type, row) {
          return `<input type="text" class="form-control" readonly value="${data ? parseFloat(data) : ''}"/>`
        }
      },
      {
        data: 'note',
        render(data, type, row) {
          return `<input type="text" class="form-control" readonly value="${data ? data : ''}"/>`
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="javascript:void(0)" id="delete_${data}" data-id="${data}" class="btn btn-light is-small table-action remove-item" data-toggle="tooltip" data-placement="top" title="Reset"><img src="http://localhost:8000/assets/images/icons/trash.svg" alt="edit" width="16"></a>`
        }
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
      $('.remove-item').click((e) => {
        const payment_lines = JSON.parse(sessionStorage.payment_lines);
        const parent = e.target.closest('tr');
        const id = e.currentTarget.id.split('_')[1];
        const latest_payment_lines = payment_lines.filter(res => res.id !== parseFloat(id));
        paymentLines = latest_payment_lines;
        sessionStorage.setItem('payment_lines', JSON.stringify(latest_payment_lines));
        $('#table-payment-lines').DataTable().row([parent]).remove().draw();
      });
    }
  })
};

if (formPaymentMeans.length > 0) {
  $('#modal-add-payment-means').on('shown.bs.modal', (e) => {
    formPaymentMeans.removeClass('was-validated');
    $('#payment_method').val('cash');
    $('#payment_type').val('down_payment');
    $('#bank_account').val('');
    $('#receiver_name').val('');
    $('#bank_id').val('');
    $('#credit_card').val('');
    $('#total_amount').val(0);
    $('#note').val()
  })
  formPaymentMeans.submit((e) => {
    paymentLines = [];
    if (sessionStorage.payment_lines) {
      JSON.parse(sessionStorage.payment_lines).forEach((response) => {
        paymentLines.push(response)
      });
    }
    $('#table-payment-lines').DataTable().destroy();
    const data = {
      id: paymentLines.length + 1,
      payment_method: $('#payment_method').val(),
      payment_type: $('#payment_type').val(),
      payment_date: $('#payment_date').val(),
      bank_account_id: $('#bank_account').val(),
      receiver_name: $('#receiver_name').val() === '-' ? '' : $('#receiver_name').val(),
      bank_id: $('select[name="bank_id"]').val(),
      bank_name: $('select[name="bank_id"]').children('option:selected').text(),
      credit_card_no: '-' || $('#credit_card').val(),
      amount: $('#total_amount').val(),
      note: $('#note').val(),
    };
    paymentLines.push(data);
    sessionStorage.setItem('payment_lines', JSON.stringify(paymentLines));
    tablePaymentLines($('#table-payment-lines'), JSON.parse(sessionStorage.payment_lines));
    $('#modal-add-payment-means').modal('hide');
    $('#field-transfer').hide();
    $('#field-credit-card').hide();
    return false;
  });
}