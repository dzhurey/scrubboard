import ajx from './../../shared/index.js';

const tablePromo = $('#table-promo');
const formCreatePromo = $('#form-create-promo');
const formEditPromo = $('#form-edit-promo');

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
    columns: [
      { data: 'name' },
      { data: 'type' },
      { data: 'code' },
      { data: 'quota' },
      { data: 'percentage' },
      { data: 'max_promo' },
      { data: 'start_promo' },
      { data: 'end_promo' },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="/promos/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
          data-placement="top" title="Edit"><img src="assets/images/icons/edit.svg" alt="edit" width="16"></a>`
        },
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};

if (formCreatePromo.length > 0) {
  $('#button-delete').remove();
  formCreatePromo.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formCreatePromo.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.post('/api/promos', data).then(res => window.location = '/promos').catch(res => {
      const errors = res.responseJSON.errors;      
      errorMessage(errors);
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })
}

if (tablePromo.length > 0) {
  ajx.get('/api/promos').then((res) => {
    createTable(tablePromo, res.promos.data);
  }).catch(res => console.log(res));
}

if (formEditPromo.length > 0) {
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/promos/${id}`)
    .then(res => {
      $('#type').val(res.promo.type);
      $('#promo_name').val(res.promo.name);
      $('#promo_code').val(res.promo.code);
      $('#promo_quota').val(res.promo.quota);
      $('#promo_percentage').val(res.promo.percentage);
      $('#promo_maximum').val(res.promo.max_promo);
      $('#start_date').val(res.promo.start_promo);
      $('#end_date').val(res.promo.end_promo);
    })
    .catch(res => console.log(res));

    formEditPromo.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formEditPromo.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.put(`/api/promos/${id}`, data).then(res => window.location = '/promos').catch(res => {
      const errors = res.responseJSON.errors;      
      errorMessage(errors);
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/promos/${id}`).then(res => window.location = '/promos').catch(res => {
      alert('Cannot delete item that has been used in transaction')
    });
  })
}