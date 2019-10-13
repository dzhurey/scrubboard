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
    searching: true,
    info: false,
    paging: true,
    pageLength: 5,
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
const updatedPrice = () => {
  const urlArray = window.location.href.split('/');
  const item_id = urlArray[urlArray.length - 2];
  $('#price_list').change((e) => {
    const id = e.target.value;
    ajx.get(`/api/items/${item_id}`)
    .then(res => {
      if (res.item.price_lines.length > 0) {
        const getById = res.item.price_lines.find(res => res.price_id.toString() === id);
        if (getById !== undefined) $('#price').val(Number.parseFloat(getById.amount));
        else $('#price').val('0');
      } 
    })
    .catch(res => console.log(res));
  });
};
const errorMessage = (data) => {
  Object.keys(data).map(key => {
    const $parent = $(`#${key}`).closest('.form-group');
    $parent.addClass('is-error');
    $parent[0].querySelector('.invalid-feedback').innerText = data[key][0];
  });
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
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formCreateItem.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.post('/api/items', data).then(res => window.location = '/items').catch(res => {
      const errors = res.responseJSON.errors;      
      errorMessage(errors);
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
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
      res.item.price_lines.map((res, i) => {
        if (i === 0) {
          $('#price_list').val(res.price_id);
          $('#price').val(Number.parseFloat(res.amount));
        }
      });
      updatedPrice();
    })
    .catch(res => console.log(res));

  formEditItem.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formEditItem.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.put(`/api/items/${id}`, data).then(res => window.location = '/items').catch(res => {
      const errors = res.responseJSON.errors;      
      errorMessage(errors);
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/items/${id}`).then(res => window.location = '/items').catch(res => {
      alert('Cannot delete item that has been used in transaction')
    });
  })
}

