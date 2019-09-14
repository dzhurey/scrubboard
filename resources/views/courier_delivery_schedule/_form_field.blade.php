<div class="row">
    <div class="col-sm-4">
        <h2 class="c-form--title">Delivery Schedule Data</h2>
        <div class="form-group">
            <label class="c-form--label" for="transaction_number">Delivery ID</label>
            <h3 id="courier_code" class="font-weight-bold"></h3>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="transaction_number">Sales Invoice ID</label>
            <h3 id="transaction_number" class="font-weight-bold"></h3>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="courier_schedule">Schedule Date</label>
            <h3 id="courier_schedule" class="font-weight-bold"></h3>
        </div>
    </div>
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <h2 class="c-form--title">Customer Data</h2>
        <div class="form-group">
            <label class="c-form--label" for="customer_name">Customer Name</label>
            <h3 id="customer_name" class="font-weight-bold"></h3>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="phone_number">Phone Number</label>
            <h3 id="phone_number" class="font-weight-bold"></h3>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="address">Address</label>
            <h3 id="address" class="font-weight-bold"></h3>
        </div>
    </div>
</div>

<div class="c-table--outer mx-0">
    <div class="table-responsive">
        <table id="table-item-courier-delivery-schedule" class="c-table table table-striped">
            <thead>
                <tr>
                    <th class="checkbox"></th>
                    <th class="th-item">Sales Invoices Id</th>
                    <th class="th-note">Customer</th>
                    <th class="th-item">Address</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<hr class="my-4">
<div class="row">
    <div class="col-sm-6 text-left"></div>
    <div class="col-sm-6 text-right">
        <a href="{{ route('courier.delivery_schedules.index') }}" class="btn btn-primary">Submit</a>
    </div>
</div>