import ajx from './../../shared/index.js';

const tableSubCategory = $('#table-sub-category');
const formCreateSubCategory = $('#form-create-sub-category');
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

if (tableSubCategory.length > 0) {
  ajx.get('/item_sub_categories').then((res) => {
    createTable(tableSubCategory, res.item_sub_categories.data);
  }).catch(res => console.log(res));
}
