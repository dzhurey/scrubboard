import ajx from './../../shared/index.js';

const tablePrice = $('#table-price');
const tableItemsList = $('#table-item-price-list');
const formCreateSubCategory = $('#form-create-price');
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
          return row.price_lines.length;
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="/prices/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
          data-placement="top" title="Edit"><img src="assets/images/icons/edit.svg" alt="edit" width="16"></a>`
        },
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};
const createTableItemLists = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    columns: [
      {
        data: 'id',
        className: 'checkbox',
        render(data) {
          return `<input type="checkbox" name="price_lines[item_id][]" value="${data}"/>`
        }
      },
      { data: 'description' },
      { data: 'price' },
    ],
  })
};

if (tablePrice.length > 0) {
  ajx.get('/api/prices').then((res) => {
    createTable(tablePrice, res.prices.data);
  }).catch(res => console.log(res));
}

if (tableItemsList.length > 0) {
  ajx.get('/api/items').then((res) => {
    createTableItemLists(tableItemsList, res.items.data);
  }).catch(res => console.log(res));
}

var $form = $('#formPrice')
var $submitButton = $('#buttonSubmit')

$submitButton.on('click', function () {
  var priceLines = []
  $('#dynamicForm .entry').each(function () {
    data = {
      item_id: $(this).find('select option:selected').val(),
      amount: $(this).find('input[name="price_lines[amount][]"]').val()
    }
    priceLines.push(data)
  })
  debugger;

  var data = {
    name: $form.find('input[name="name"]').val(),
    price_lines: priceLines
  }

  $.ajax({
    url: $form.attr('action'),
    type: 'post',
    data: JSON.stringify(data),
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
      "X-CSRF-TOKEN": $form.find('input[name="_token"]').val()
    },
    dataType: 'json',
    success: function (data) {
      alert('data berhasil disimpan');
    }
  });
})
