import ajx from './../../shared/index.js';

const tableCourierPS = $('#table-courier-pickup-schedule');

if (tableCourierPS.length > 0) {
  debugger;
  ajx.get('api/courier/pickup_schedules').then((res) => {
    debugger;
    // createTable(tablePrice, res.prices.data);
  }).catch(res => console.log(res));
}