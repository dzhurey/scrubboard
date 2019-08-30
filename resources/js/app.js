/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */
require('./../assets/vendor/jquery/dist/jquery.min.js');
require('./../assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js');
require('moment');
require('datatables.net-dt');
require('./../assets/vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');

require('./pages/login/index.js');
require('./pages/customers/index.js');
require('./pages/item_sub_categories/index.js');
require('./pages/item_groups/index.js');
require('./pages/item/index.js');
require('./pages/price/index.js');
require('./pages/vehicle/index.js');
require('./pages/bank/index.js');
require('./pages/agent/index.js');
require('./pages/courir/index.js');
require('./pages/people/index.js');
require('./pages/sales_order/index.js');
require('./pages/pickup_schedule/index.js');
require('./pages/delivery_schedule/index.js');
require('./pages/sales_invoice/index.js');
require('./pages/courier_pickup/index.js');
require('./pages/courier_delivery/index.js');
require('./pages/payment/index.js');

require('./prototype/select2.js');
require('./prototype/main.js');