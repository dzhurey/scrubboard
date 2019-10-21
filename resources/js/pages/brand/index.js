import ajx from './../../shared/index.js';

const tableCategory = $('#table-brand');
const formCreateCategory = $('#form-create-brand');
const formEditCategory = $('#form-edit-brand');
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
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="/brands/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
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
      input.val(data[key]);
    }
  })
};

if (tableCategory.length > 0) {
  ajx.get('/api/brands').then((res) => {
    createTable(tableCategory, res.brands.data);
  }).catch(res => console.log(res));
}

if (formCreateCategory.length > 0) {
  $('#button-delete').remove();
  formCreateCategory.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formCreateCategory.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.post('/api/brands', data).then(res => window.location = '/brands').catch(res => {
      console.log(res);
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  });
}

if (formEditCategory.length > 0) {
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/brands/${id}`)
    .then(res => assignValue(res.item_group))
    .catch(res => console.log(res));

  formEditCategory.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formEditCategory.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.put(`/api/brands/${id}`, data).then(res => window.location = '/brands').catch(res => {
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/item_groups/${id}`).then(res => window.location = '/item_groups').catch(res => {
      alert(res.responseJSON.message)
    });
  })
}
