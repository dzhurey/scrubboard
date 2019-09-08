import ajx from './../../shared/index.js';

const customerList = $('#customer_id');
const statusOrder = $('#status_order');
const orderType = $('#order_type');
const outletList = $('#agent_id');
const modalCustomerFormTable = $('#modal-customer-form-table');
const modalCustomerForm = $('#modal-customer-form');

const createTableCustomerFormTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: true,
    pageLength: 10,
    columns: [
      {
        data: 'id',
        render(data, type, row) {
          return `<input type="radio" name="customer_id_radio" class="check-customer" value="${data}" price-id="${row.price_id}" customer-name="${row.name}" required/>`
        }
      },
      { data: 'id' },
      { data: 'name' },
      { 
        data: 'shipping_address',
        render(data, type, row) {
          return `${data.description}, ${data.district}, ${data.city}, ${data.country} ${data.zip_code}`
        }
      },
      { data: 'phone_number' },
      { 
        data: 'id',
        render(data) {
          return '';
        }
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
      $('.check-customer').change((e) => {
        const price_id = e.target.getAttribute('price-id');
        const name = e.target.getAttribute('customer-name');
        const customer_id = e.target.value;
        sessionStorage.setItem('choosed_customer', JSON.stringify({ customer_id: customer_id, name: name, price_id: price_id }));
      });
    }
  })
};

const getPriceList = (id) => {
  ajx.get(`/api/prices/${id}`).then((res) => {
    const prices = res.price.price_lines;
    sessionStorage.setItem('prices_lines', JSON.stringify(prices));
  }).catch(res => console.log(res));
}

if (modalCustomerForm.length > 0) {
  ajx.get('/api/customers').then((res) => {
    const customers = res.customers.data;
    createTableCustomerFormTable(modalCustomerFormTable, customers);
  }).catch(res => console.log(res));

  modalCustomerForm.submit((e) => {
    e.preventDefault();
    const choosed_customer = JSON.parse(sessionStorage.choosed_customer);
    $('#modal-customer').modal('hide');
    $('#customer_id').val(choosed_customer.name);
    $('#customer_id').attr('customer-id', choosed_customer.customer_id);
    return false;
  });
}

if (statusOrder.length > 0) {
  statusOrder.val(orderType.val() === 'general' ? 'open' : 'closed');
  orderType.change((e) => {
    statusOrder.val(e.target.value === 'general' ? 'open' : 'closed');
  });
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