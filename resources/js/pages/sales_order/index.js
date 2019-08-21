import ajx from './../../shared/index.js';

const customerList = $('#customer_id');
const outletList = $('#outlet');
const orderType = $('#order_type');
const statusOrder = $('#status_order');
const listItems = $('.list-item');
const formCreateSalesOrder = $('#form-create-sales-order');
const tableSOItems = $('#table-so-item');
const chooseCustoemr = () => {
  customerList.change((e) => {
    ajx.get(`/api/customers/${e.target.value}`).then((res) => {
      ajx.get(`/api/prices/${res.customer.price_id}`).then((res) => {
        const prices = res.price.price_lines;
        createTableSO(tableSOItems, prices);
      }).catch(res => console.log(res));
    }).catch(res => console.log(res)).abort();
  })
};
const createTableSO = (target, data) => {
  target.DataTable({
    destroy: true,
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: true,
    pageLength: 30,
    columns: [
      { 
        data: 'id',
        render(data) {
          return data
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return data
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return data
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return data
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return data
        }
      },
      { 
        data: 'id',
        render(data, type, row) {
          return data
        }
      },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="#" class="btn btn-light is-small table-action" data-toggle="tooltip"
          data-placement="top" title="Edit"><img src="./../assets/images/icons/edit.svg" alt="edit" width="16"></a>`
        },
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
      chooseCustoemr();
    }
  })
};

if (customerList.length > 0) {
  ajx.get('/api/customers').then((res) => {
    const items = res.customers.data;
    for (let item of items) {
      const option = document.createElement('option');
      option.value = item.id;
      option.textContent = `${item.name}`;
      customerList.append(option);
    }
  }).catch(res => console.log(res));
}

if (outletList.length > 0) {
  ajx.get('/api/agents').then((res) => {
    const items = res.agents.data;
    for (let item of items) {
      const option = document.createElement('option');
      option.value = item.id;
      option.textContent = `${item.name}`;
      outletList.append(option);
    }
  }).catch(res => console.log(res));
}

if (formCreateSalesOrder.length > 0) {
  statusOrder.val(orderType.val() === 'general' ? 'open' : 'closed');
  orderType.change((e) => {
    statusOrder.val(e.target.value === 'general' ? 'open' : 'closed');
  });
  chooseCustoemr();
}