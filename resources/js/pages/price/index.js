import ajx from './../../shared/index.js';

let priceList = [];
const tablePrice = $('#table-price');
const tableItemsList = $('#table-item-price-list');
const formCreatePrice = $('#form-create-price');
const formEditPrice = $('#form-edit-price');
const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: true,
    pageLength: 5,
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
const collectPriceLines = () => {
  $('.check-price-item').change((e) => {
    const item_id = e.target.value;
    const amount = e.target.parentElement.parentElement.querySelector('.field-price-item').value;
    if (e.target.checked) {
      priceList.push({
        item_id: item_id,
        amount: amount,
      })
    } else {
      priceList = priceList.filter(item => item.item_id === e.target.value);
      debugger;
    }
  });
}
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
          return `<input id="check-${data}" class="check-price-item" type="checkbox" name="price_lines[item_id][]" value="${data}"/>`
        }
      },
      { data: 'description' },
      { 
        data: 'price',
        render(data) {
          return `<input class="field-price-item form-control" style="width: 200px;" type="text" name="price_lines[amount][]" value="${data}"/>`
        }
      },
    ],
    drawCallback: () => {
      collectPriceLines();
    },
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

if (formCreatePrice.length > 0) {
  $('#button-delete').remove();
  formCreatePrice.submit((e) => {
    e.preventDefault();
    ajx.post('/api/prices', {
      name: $('#name').val(),
      price_lines: priceList,
    }).then(res => window.location = '/prices').catch(res => console.log(res));
    return false;
  });
}

if (formEditPrice.length > 0) {
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/prices/${id}`)
    .then(res => {
      $('#name').val(res.price.name);
      const prices = res.price.price_lines;
      prices.map(res => {
        $(`#check-${res.item_id}`).attr('checked', true);
        if ($(`#check-${res.item_id}`).prop('checked')) {
          const item_id = $(`#check-${res.item_id}`).val();
          const amount = $(`#check-${res.item_id}`).closest('tr')[0].querySelector('.field-price-item').value;
          priceList.push({
            item_id: item_id,
            amount: amount,
          })
        }
      });
    })
    .catch(res => console.log(res));

  formEditPrice.submit((e) => {
    e.preventDefault();
    const dataForm = formEditPrice.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    debugger;
    ajx.put(`/api/prices/${id}`, {
      name: $('#name').val(),
      price_lines: priceList,
    }).then(res => window.location = '/prices').catch(res => console.log(res));
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/prices/${id}`).then(res => window.location = '/prices').catch(res => {
      alert(res.responseJSON.message)
    });
  })
}

