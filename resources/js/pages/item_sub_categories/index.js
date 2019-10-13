import ajx from './../../shared/index.js';

const tableSubCategory = $('#table-sub-category');
const formCreateSubCategory = $('#form-create-sub-category');
const formEditSubCategory = $('#form-edit-sub-category');
const selectCategory = $('#item_group_id');
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
          return `<a href="/item_sub_categories/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
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
    if($(`select[name=${key}]`).length > 0) $(`select[name=${key}]`).val(data[key]);
  })
};

if (selectCategory.length > 0) {
  ajx.get('/item_groups').then((res) => {
    const items = res.item_groups.data;
    for (let item of items) {
      const option = document.createElement('option');
      option.value = item.id;
      option.textContent = item.name;
      selectCategory.append(option);
    }
  }).catch(res => console.log(res));
}

if (tableSubCategory.length > 0) {
  ajx.get('/item_sub_categories').then((res) => {
    createTable(tableSubCategory, res.item_sub_categories.data);
  }).catch(res => console.log(res));
}

if (formCreateSubCategory.length > 0) {
  $('#button-delete').remove();
  formCreateSubCategory.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formCreateSubCategory.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.post('/api/item_sub_categories', data).then(res => window.location = '/item_sub_categories').catch(res => {
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  });
}

if (formEditSubCategory.length > 0) {
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/item_sub_categories/${id}`)
    .then(res => assignValue(res.item_sub_category))
    .catch(res => console.log(res));

  formEditSubCategory.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formEditSubCategory.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.put(`/api/item_sub_categories/${id}`, data).then(res => window.location = '/item_sub_categories').catch(res => {
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/item_sub_categories/${id}`).then(res => window.location = '/item_sub_categories').catch(res => {
      alert('Cannot delete sub category')
    });
  })
}

