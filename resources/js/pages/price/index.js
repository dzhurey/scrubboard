import ajx from './../../shared/index.js';

const tablePrice = $('#table-price');
const tableItemsList = $('#table-item-price-list');
const formCreatePrice = $('#form-create-price');
const formEditPrice = $('#form-edit-price');

const collectPriceLines = (isEdit) => {
  if (isEdit) {
    const price_lines = JSON.parse(sessionStorage.price_lines);
    price_lines.forEach((res) => $(`#price_${res.item_id}`).val(Number.parseFloat(res.amount)));
  }

  // $('.field-price-item').change((e) => {
  //   const price_lines = JSON.parse(sessionStorage.item_price);
  //   sessionStorage.setItem('updated_price', e.target.value);
  //   sessionStorage.setItem('updated_price_by_id', e.target.getAttribute('data-id'));
  //   price_lines.map(obj => 
  //     price_lines.find(o => {
  //       const updated_price_by_id = parseInt(sessionStorage.updated_price_by_id);
  //       o.amount = o.item_id === updated_price_by_id ? sessionStorage.updated_price : o.amount;
  //     }) || obj
  //   );
  //   sessionStorage.clear();
  //   sessionStorage.setItem('item_price', JSON.stringify(price_lines));
  // });
}

const createTable = (target, data) => {
  target.DataTable({
    // scrollX: true,
    data: data,
    lengthChange: true,
    lengthMenu: [ 15, 25, 50, 100 ],
    searching: true,
    info: true,
    paging: true,
    pageLength: 15,
    columns: [
      { data: 'name' },
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

const createTableItemLists = (target, data, isEdit) => {
  target.DataTable({
    // scrollX: true,
    data: data,
    lengthChange: true,
    lengthMenu: [ 15, 25, 50, 100 ],
    searching: true,
    info: true,
    paging: true,
    pageLength: 1,
    columns: [
      { 
        data: 'description',
        render(data) {
          return `<input class="field-name-item form-control" type="text" name="price_lines[amount][]" value="${data}" disabled readOnly/>`
        }
      },
      { 
        data: 'price',
        render(data, type, row) {
          return `<div class="input-group flex-nowrap">
          <div class="input-group-prepend">
              <span class="input-group-text">Rp</span>
          </div>
          <input id="price_${row.id}" data-id="${row.id}" class="field-price-item form-control" style="width: 200px;" type="text" name="price_lines[amount][]" value="${data !== undefined ? data : 0}"/></div>`
        }
      },
    ],
    drawCallback: () => {
      collectPriceLines(isEdit);

      $('.field-price-item').change((e) => {
        const price_lines = JSON.parse(sessionStorage.price_lines);
        const item_id = parseInt(e.target.getAttribute('data-id'));
        const amount = e.target.value;
        const new_price_lines = price_lines.map((res) => {
          if (res.item_id === item_id) {
            res.amount = amount;
          }
          return res;
        });
  
        sessionStorage.removeItem('price_lines');
        sessionStorage.setItem('price_lines', JSON.stringify(new_price_lines));
      });
    },
  })
};

const renderTable = (isEdit) => {
  if (tableItemsList.length > 0) {
    sessionStorage.clear();
    ajx.get('/api/items').then((res) => {
      const data = res.items.data;
      const array = [];
      data.map(res => array.push({
        item_id: res.id,
        amount: res.price,
      }));
      sessionStorage.setItem('item_price', JSON.stringify(array));
      createTableItemLists(tableItemsList, res.items.data, isEdit);
    }).catch(res => console.log(res));
  }
}

const errorMessage = (data) => {
  Object.keys(data).map(key => {
    const $parent = $(`#${key}`).closest('.form-group');
    $parent.addClass('is-error');
    $parent[0].querySelector('.invalid-feedback').innerText = data[key][0];
  });
};

if (formCreatePrice.length > 0) {
  $('#button-delete').remove();
  renderTable();
  formCreatePrice.submit((e) => {
    e.preventDefault();
    const price_lines_data = JSON.parse(sessionStorage.price_lines);
    $('button[type="submit"]').attr('disabled', true);
    ajx.post('/api/prices', {
      name: $('#name').val(),
      price_lines: price_lines_data,
    }).then(res => window.location = '/prices').catch(res => {
      const errors = res.responseJSON.errors;      
      errorMessage(errors);
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  });
}

if (tablePrice.length > 0) {
  ajx.get('/api/prices').then((res) => {
    createTable(tablePrice, res.prices.data);
  }).catch(res => console.log(res));
}

if (formEditPrice.length > 0) {
  sessionStorage.clear();
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  const price_lines_data = [];
  ajx.get(`/api/prices/${id}`)
    .then(res => {
      $('#name').val(res.price.name);
      renderTable(true);
      sessionStorage.setItem('price_lines', JSON.stringify(res.price.price_lines));
    })
    .catch(res => console.log(res));

  formEditPrice.submit((e) => {
    const price_lines_data = JSON.parse(sessionStorage.price_lines);
    debugger
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    ajx.put(`/api/prices/${id}`, {
      name: $('#name').val(),
      price_lines: price_lines_data,
    }).then(res => window.location = '/prices').catch(res => {
      const errors = res.responseJSON.errors;      
      errorMessage(errors);
      console.log(res)
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/prices/${id}`).then(res => window.location = '/prices').catch(res => {
      alert(res.responseJSON.message)
    });
  })
}