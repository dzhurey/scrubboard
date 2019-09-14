import ajx from './../../shared/index.js';

const tableCourierList = $('#table-courier-schedule');

const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: true,
    pageLength: 10,
    columns: [
      { data: 'id' },
      { data: 'transaction_line.transaction_number' },
      { data: 'transaction_line.bor' },
      { 
        data: 'transaction_line.transaction',
        render(data, type, row) {
          return `${row.transaction_line.transaction.agent ? row.transaction_line.transaction.agent.name : row.transaction_line.transaction.customer.name}`
        }
      },
      {
        data: 'transaction_line.address',
        render(data) {
          return `${data.description}, ${data.district}, ${data.city}, ${data.country} ${data.zip_code}`;
        }
      },
      { data: 'transaction_line.item.description' },
      { data: 'transaction_line.brand.name' },
      { data: 'transaction_line.color' },
      { 
        data: 'transaction_line.color',
        render() {
          return 'courier';
        }
      },
      { 
        data: 'transaction_line.color',
        render() {
          return 'vehicle';
        }
      },
      { data: 'status' },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};

if (tableCourierList.length > 0) {
  ajx.get('/api/courier_schedules').then((res) => {
    createTable(tableCourierList, res.courier_schedules.data);
  }).catch(res => console.log(res));
}
