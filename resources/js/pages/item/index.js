import ajx from './../../shared/index.js';

const tableItem = $('#table-item');
const formCreateItem = $('#form-create-item');
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
