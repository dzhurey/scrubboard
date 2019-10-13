import ajx from './../../shared/index.js';

const tableCategory = $('#table-category');
const formCreateCategory = $('#form-create-category');
const formEditCategory = $('#form-edit-category');
const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: true,
    info: false,
    paging: true,
    pageLength: 5,
    columns: [
      { data: 'name' },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="/item_groups/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
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
  ajx.get('/api/item_groups').then((res) => {
    createTable(tableCategory, res.item_groups.data);
  }).catch(res => console.log(res));
}

if (formCreateCategory.length > 0) {
  $('#button-delete').remove();
  formCreateCategory.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formCreateCategory.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.post('/api/item_groups', data).then(res => window.location = '/item_groups').catch(res => {
      console.log(res);
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  });
}

if (formEditCategory.length > 0) {
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/item_groups/${id}`)
    .then(res => assignValue(res.item_group))
    .catch(res => console.log(res));

  formEditCategory.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formEditCategory.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.put(`/api/item_groups/${id}`, data).then(res => window.location = '/item_groups').catch(res => {
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/item_groups/${id}`).then(res => window.location = '/item_groups').catch(res => {
      alert('Cannot delete category')
    });
  })
}
