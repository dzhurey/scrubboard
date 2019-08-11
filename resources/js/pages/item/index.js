import ajx from './../../shared/index.js';

const tableItem = $('#table-item');
const formCreateItem = $('#form-create-item');
const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    columns: [
      { data: 'description' },
      { data: 'item_type' },
      { data: 'service' },
      { data: 'product' },
      { data: 'item_sub_category_id' },
      { data: 'price' },
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
  ajx.get('/items').then((res) => {
    debugger
    createTable(tableCategory, res.item_groups.data);
  }).catch(res => console.log(res));
}
