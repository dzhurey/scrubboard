import ajx from './../../shared/index.js';

const customerList = $('#customer_id');
const outletList = $('#outlet');
const orderType = $('#order_type');
const statusOrder = $('#status_order');
const formCreateSalesOrder = $('#form-create-sales-order');

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
  })
}