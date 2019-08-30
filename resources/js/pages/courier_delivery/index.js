import ajx from './../../shared/index.js';

const tableCourierDS = $('#table-courier-delivery-schedule');
const formEditCourierDS = $('#form-edit-courier-delivery-schedule');
const formItemCourierDS = $('#table-item-courier-delivery-schedule');
const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: true,
    pageLength: 5,
    columns: [
      { data: 'transaction.transaction_number' },
      {
        data: 'transaction.customer.shipping_address.description',
        render(data, type, row) {
          const address = row.transaction.customer.shipping_address;
          return `${address.description}, ${address.district}, ${address.city}, ${address.country} ${address.zip_code}`
        }
      },
      { data: 'transaction.delivery_date' },
      { data: 'estimation_time' },
      { data: 'status' },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="/courier/delivery_schedules/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
          data-placement="top" title="Edit"><img src="${window.location.origin}/assets/images/icons/edit.svg" alt="edit" width="16"></a>`
        },
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};

const createTableItemCourierSP = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: true,
    pageLength: 5,
    columns: [
      { data: 'item.description' },
      { data: 'bor' },
      { data: 'note' },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};

if (tableCourierDS.length > 0) {
  ajx.get('/api/courier/delivery_schedules').then((res) => {
    createTable(tableCourierDS, res.courier_delivery_schedules.data);
  }).catch(res => console.log(res));
}

if (formEditCourierDS.length > 0) {
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/courier/delivery_schedules/${id}`).then((res) => {
    const data = res.courier_schedule_line;
    const customer = data.transaction.customer;
    const items = data.transaction.transaction_lines;
    $('#transaction_number').text(data.transaction.transaction_number);
    $('#estimation_time').text(data.estimation_time);
    $('#courier_schedule').text(data.courier_schedule.schedule_date);
    $('#customer_name').text(customer.name);
    $('#phone_number').text(customer.phone_number);
    $('#address').text(`${customer.shipping_address.description}, ${customer.shipping_address.district}, ${customer.shipping_address.city}, ${customer.shipping_address.country}, ${customer.shipping_address.zip_code}`);
    createTableItemCourierSP(formItemCourierDS, items);
  }).catch(res => console.log(res));

  formEditCourierDS.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const formData = new FormData(e.currentTarget);

    $.ajax({
      type: 'POST',
      enctype: 'multipart/form-data',
      cache: false,
      processData: false,
      contentType: false,
      url: `/api/courier/delivery_schedules/${id}`,
      data: formData,
      success: (res) => {
        debugger
      },
      error: (res) => {
        debugger
      }
    });

    return false;
  });
}