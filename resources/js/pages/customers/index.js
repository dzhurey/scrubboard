import ajx from './../../shared/index.js';

const tableCustomer = $('#table-customer');
const formCreateCustomer = $('#form-create-customer');
const formEditCustomer = $('#form-edit-customer');
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
      { data: 'partner_type' },
      { data: 'name' },
      { data: 'phone_number' },
      { data: 'created_at' },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="/customers/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
          data-placement="top" title="Edit"><img src="assets/images/icons/edit.svg" alt="edit" width="16"></a>`
        },
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};
const assignValue = (data) => {
  const keys = Object.keys(data);
  keys.forEach((key) => {
    if($(`input[name=${key}]`).length > 0) {
      const input = $(`input[name=${key}]`);
      if(input.attr('type') === 'radio') {
        $(`#${key}_${data[key]}`).attr('checked', true);
      } else {
        input.val(data[key]);
      }
    }
    if($(`select[name=${key}]`).length > 0) $(`select[name=${key}]`).val(data[key]);
    if($(`textarea[name=${key}]`).length > 0) $(`textarea[name=${key}]`).val(data[key]);
  })
};
const errorMessage = (data) => {
  Object.keys(data).map(key => {
    const $parent = $(`#${key}`).closest('.form-group');
    $parent.addClass('is-error');
    $parent[0].querySelector('.invalid-feedback').innerText = data[key][0];
  });
};

if (tableCustomer.length > 0) {
  ajx.get('/api/customers').then((res) => {
    createTable(tableCustomer, res.customers.data);
  }).catch(res => console.log(res));
}

if (formEditCustomer.length > 0) {
  const urlArray = window.location.href.split('/');
  const idCustomer = urlArray[urlArray.length - 2];
  ajx.get(`/api/customers/${idCustomer}`)
    .then((res) => {
      assignValue(res.customer)
      $('#billing_address').val(res.customer.billing_address.description);
      $('#billing_district').val(res.customer.billing_address.district);
      $('#billing_city').val(res.customer.billing_address.city);
      $('#billing_country').val(res.customer.billing_address.country);
      $('#billing_zip_code').val(res.customer.billing_address.city);
      $('#shipping_address').val(res.customer.shipping_address.description);
      $('#shipping_district').val(res.customer.shipping_address.district);
      $('#shipping_city').val(res.customer.shipping_address.city);
      $('#shipping_country').val(res.customer.shipping_address.country);
      $('#shipping_zip_code').val(res.customer.shipping_address.city);
      $('#is_same_address').attr('checked', res.customer.shipping_address.is_billing && res.customer.shipping_address.is_shipping);
      if($('#is_same_address').prop('checked')) $('#is_same_address_content').hide();
    })
    .catch(res => console.log(res));

  formEditCustomer.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formEditCustomer.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.put(`/api/customers/${idCustomer}`, data).then(res => window.location = '/customers').catch(res => {
      const errors = res.responseJSON.errors;      
      errorMessage(errors);
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/customers/${idCustomer}`).then(res => window.location = '/customers').catch(res => {
      alert('Cannot delete customer that has been used in transaction');
    });
  })
}

if (formCreateCustomer.length > 0) {
  $('#button-delete').remove();
  formCreateCustomer.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formCreateCustomer.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.post('/api/customers', data).then(res => window.location = '/customers').catch(res => {
      const errors = res.responseJSON.errors;      
      errorMessage(errors);
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })
}