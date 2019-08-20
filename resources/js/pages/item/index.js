import ajx from './../../shared/index.js';

const tableItem = $('#table-item');
const formCreateItem = $('#form-create-item');
const formEditItem = $('#form-edit-item');
const selectSubCategory = $('#item_sub_category_id');
const selectPriceLists = $('#price_list');
const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    columns: [
      { data: 'description' },
      {
        data: 'item_group',
        render(data) {
          return data.name;
        }
      },
      {
        data: 'item_sub_category',
        render(data) {
          return data.name;
        }
      },
      {
        data: 'price',
        render(price) {
          return `Rp ${price}`
        },
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="/items/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
          data-placement="top" title="Edit"><img src="assets/images/icons/edit.svg" alt="edit" width="16"></a>`
        },
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};

if (tableItem.length > 0) {
  ajx.get('/api/items').then((res) => {
    createTable(tableItem, res.items.data);
  }).catch(res => console.log(res));
}

if (selectSubCategory.length > 0) {
  ajx.get('/api/item_sub_categories').then((res) => {
    const items = res.item_sub_categories.data;
    for (let item of items) {
      const option = document.createElement('option');
      option.value = item.id;
      option.textContent = item.name;
      selectSubCategory.append(option);
    }
  }).catch(res => console.log(res));
}

if (selectPriceLists.length > 0) {
  ajx.get('/api/prices').then((res) => {
    const items = res.prices.data;
    for (let item of items) {
      const option = document.createElement('option');
      option.value = item.id;
      option.textContent = item.name;
      selectPriceLists.append(option);
    }
  }).catch(res => console.log(res));
}

if (formCreateItem.length > 0) {
  $('#button-delete').remove();
  formCreateItem.submit((e) => {
    e.preventDefault();
    const dataForm = formCreateItem.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.post('/api/items', data).then(res => window.location = '/items').catch(res => console.log(res));
    return false;
  })
}

if (formEditItem.length > 0) {
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/items/${id}`)
    .then(res => {
      $('#item_type').val(res.item.item_type);
      $('#description').val(res.item.description);
      $('#item_group_id').val(res.item.item_group.id);
      $('#item_sub_category_id').val(res.item.item_sub_category.id);
    })
    .catch(res => console.log(res));

  formEditItem.submit((e) => {
    e.preventDefault();
    const dataForm = formEditItem.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.put(`/api/items/${id}`, data).then(res => window.location = '/items').catch(res => console.log(res));
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/items/${id}`).then(res => window.location = '/items').catch(res => {
      alert(res.responseJSON.message)
    });
  })
}

