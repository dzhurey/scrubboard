import ajx from './../../shared/index.js';

const tableCategory = $('#table-category');
const formCreateCategory = $('#form-create-category');
const formEditCategory = $('#form-edit-category');
const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
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
  ajx.get('/item_groups').then((res) => {
    createTable(tableCategory, res.item_groups.data);
  }).catch(res => console.log(res));
}

if (formCreateCategory.length > 0) {
  $('#button-delete').remove();
  formCreateCategory.submit((e) => {
    e.preventDefault();
    const dataForm = formCreateCategory.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.post('/item_groups', data).then(res => window.location = '/item_groups').catch(res => console.log(res));
    return false;
  });
}

if (formEditCategory.length > 0) {
  const urlArray = window.location.href.split('/');
  const idCategory = urlArray[urlArray.length - 2];
  ajx.get(`/item_groups/${idCategory}`)
    .then(res => assignValue(res.item_group))
    .catch(res => console.log(res));

  formEditCategory.submit((e) => {
    e.preventDefault();
    const dataForm = formEditCategory.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.put(`/item_groups/${idCategory}/update`, data).then(res => window.location = '/item_groups').catch(res => console.log(res));
    return false;
  })
}
