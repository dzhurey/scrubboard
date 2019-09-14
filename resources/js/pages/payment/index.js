import ajx from './../../shared/index.js';

const tablePayment = $('#table-payment');
const formCreatePayment = $('#form-create-payment');
const salesInvoicePayment = $('#payment-sales-invoice-id');
const paymentMethod = $('#payment_method');
const bankAccount = $('#bank_account');
const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: true,
    pageLength: 5,
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

if (salesInvoicePayment.length > 0) {
  ajx.get('/api/sales_invoices').then((res) => {
    sessionStorage.setItem('sales_invoices', JSON.stringify(res.sales_invoices.data));
    for (let item of res.sales_invoices.data) {
      const option = document.createElement('option');
      option.value = item.id;
      option.textContent = `${item.transaction_number}`;
      salesInvoicePayment.append(option);
  
      salesInvoicePayment.select2({ 
        theme: 'bootstrap',
        placeholder: 'Choose option',
      });
    }
  }).catch(res => console.log(res));

  salesInvoicePayment.change((e) => {
    const items = JSON.parse(sessionStorage.sales_invoices);
    const id = parseFloat(e.target.value);
    for (let item of items) {
      if (item.id === id) {
        $('#customer-name').val(item.customer.name);
        $('#customer-name').attr('customer-id', item.customer.id);
        $('#transaction_type').val(item.transaction_type);
        $('#total-amount').val(item.total_amount);
        $('#amount').val(item.total_amount);
      }
    }
  })
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
      "transaction_id" : $('#payment-sales-invoice-id').val(),
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