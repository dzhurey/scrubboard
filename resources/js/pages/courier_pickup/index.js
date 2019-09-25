import ajx from './../../shared/index.js';

const tableCourierPS = $('#table-courier-pickup-schedule');
const formEditCourierPS = $('#form-edit-courier-pickup-schedule');
const formItemCourierPS = $('#table-item-courier-pickup-schedule');
const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: true,
    pageLength: 5,
    columns: [
      { data: 'courier_code' },
      { data: 'person.name' },
      { data: 'vehicle.number' },
      { data: 'schedule_date' },
      { 
        data: 'id',
        render(data, type, row) {
          const agent = row.transaction.agent;
          return `${agent.name}`
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          const address = row.transaction.address;
          return `${address.description}, ${address.district}, ${address.city}, ${address.country} ${address.zip_code}`
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="/courier/pickup_schedules/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
          data-placement="top" title="Edit"><img src="${window.location.origin}/assets/images/icons/edit.svg" alt="edit" width="16"></a>`
        },
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};

const createSOTable = (target, data) => {
  const format = (d) => {
    let row = '';
    const items = d.transaction_lines;
    items.map((res) => {
      row += `<tr>
        <td>${res.transaction_line.item.description}</td>
        <td>${res.transaction_line.bor}</td>
        <td>${res.transaction_line.brand.name}</td>
        <td>${res.transaction_line.color}</td>
        <td>
          <input type="time" class="form-control" name="eta" ${res.status !== 'open' ? '' : 'required' } readonly value="${res.estimation_time}" ${res.status === 'canceled' ? 'disabled' : '' }>
        </td>
        <td>
          <form class="upload-photo" enctype="multipart/form-data">
          <img class="img-preview img-preview-${res.id} mb-2 ${res.image_name === null ? 'd-none' : ''}" src="${res.image_name !== null ? window.location.origin+res.image_path : ''}" width="100" />
            <input type="file" data-id="${res.id}" accept="image/*" capture class="form-control is-height-auto upload_photo" name="image">
            <input id="method" type="hidden" name="_method" value="put">
            <button type="submit" class="btn btn-primary btn-upload-photo btn-upload-photo-${res.id}">Upload</button>
          </form>
        </td>
        <td></td>
      </tr>`;
    });

    return `<table cellpadding="0" cellspacing="0" border="0" width="100%"><thead>
      <tr>
        <th>Item</th>
        <th>BOR</th>
        <th>Brand</th>
        <th>Color</th>
        <th class="th-qty">ETA</th>
        <th class="th-item">Photo</th>
        <th></th>
      </tr>
    </thead><tbody>${row}</tbody></table>`;
  };

  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: false,
    pageLength: 10,
    columns: [
      {
        className: 'details-control',
        orderable: false,
        data: null,
        defaultContent: ''
      },
      { data: 'transaction_number' },
      { 
        data: 'id',
        render(data, type, row) {
          return `${row.customer ? row.customer.name : '-'}`;
        }
      },
      {
        data: 'address',
        render(data) {
          return `${data.description}, ${data.district}, ${data.city}, ${data.country} ${data.zip_code}`;
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return '';
        }
      },
    ],
    drawCallback: () => {
      $('#table-item-courier-pickup-schedule tbody td.details-control').each((i, item) => {
        $(item).click((e) => {
          const tr = $(e.target).closest('tr');
          const row = formItemCourierPS.DataTable().row( tr );
          
          if ( row.child.isShown() ) {
              row.child.hide();
              tr.removeClass('shown');
          }
          else {
              row.child( format(row.data()) ).show();
              tr.addClass('shown');
          }

          $('.transaction_id').click((e) => {
            if (e.target.checked) {
              e.target.closest('tr').querySelector('input[name="eta"]').setAttribute('required', true);
            } else {
              e.target.closest('tr').querySelector('input[name="eta"]').removeAttribute('required')
            }
          });

          uploadImage();
        })
      });
    },
  })
};

const generateDataPickupEdit = (list_id) => {
  createSOTable(formItemCourierPS, list_id);
};

const uploadImage = () => {
  $('.upload-photo').change((e) => {
    const input = e.target;
    sessionStorage.clear();
    sessionStorage.setItem('target_image', input.getAttribute('data-id'));
    if (input.files && input.files[0]) {
      const reader = new FileReader();
    
      reader.onload = (e) => {
        $(`.img-preview-${sessionStorage.target_image}`).attr('src', e.target.result);
        $(`.img-preview-${sessionStorage.target_image}`).addClass('mb-3');
        $(`.img-preview-${sessionStorage.target_image}`).removeClass('d-none');
        $(`.btn-upload-photo-${sessionStorage.target_image}`).removeClass('d-none');
      }
      
      reader.readAsDataURL(input.files[0]);
    }
  })

  $('.upload-photo').submit((e) => {
    e.preventDefault();
    const formData = new FormData(e.currentTarget);
    const line_id = e.currentTarget.querySelector('.upload_photo').getAttribute('data-id');

    $.ajax({
      type: 'POST',
      enctype: 'multipart/form-data',
      cache: false,
      processData: false,
      contentType: false,
      url: `/api/courier/pickup_schedules/${line_id}`,
      data: formData,
      success: (res) => {
        window.location = '/courier/pickup_schedules'
      },
      error: (res) => {
        console.log(res);
      }
    });

    return false;
  })
};

if (tableCourierPS.length > 0) {
  ajx.get('/api/courier/pickup_schedules?filter[]=pickup_status,!=,done').then((res) => {
    createTable(tableCourierPS, res.pickup_schedules.data);
  }).catch(res => console.log(res));
}

if (formEditCourierPS.length > 0) {
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/courier/pickup_schedules/${id}`).then((res) => {
    const groupBy = (xs, key) => {
      return xs.reduce((rv, x) => {
        (rv['transaction_lines'] = rv['transaction_lines'] || []).push(x);
        return {
          id: x[key],
          address: x.transaction_line.address,
          customer: x.transaction_line.transaction.customer || x.transaction_line.transaction.agent,
          transaction_number: x.transaction_line.transaction_number,
          transaction_lines: rv['transaction_lines'],
        };
      }, {});
    };

    const data_line = groupBy(res.pickup_schedule.courier_schedule_lines, 'transaction_id');
    sessionStorage.setItem('choosed_so', JSON.stringify([data_line]));
    generateDataPickupEdit([data_line]);
    const data = res.pickup_schedule;
    const customer = data_line.customer;
    const address = data_line.address;
    const outlet = data_line.transaction_lines[0].transaction.agent.name;
    $('#courier_code').text(data.courier_code);
    $('#transaction_number').text(data_line.transaction_number);
    $('#courier_schedule').text(data.schedule_date);
    $('#customer_name').text(customer ? customer.name : '-');
    $('#phone_number').text(customer ? customer.phone_number : '-');
    $('#outlet').text(outlet ? outlet : '-');
    $('#address').text(`${address.description}, ${address.district}, ${address.city}, ${address.country}, ${address.zip_code}`);
  }).catch(res => {
    console.log(res);
    $('button[type="submit"]').attr('disabled', false);
  });
}