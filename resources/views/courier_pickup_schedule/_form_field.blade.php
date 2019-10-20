<div class="row">
    <div class="col-sm-6 mb-4">
        <h2 class="c-form--title">Pickup Schedule Data</h2>
        <div class="form-group">
            <label class="c-form--label" for="transaction_number">Pickup ID</label>
            <p id="courier_code" class="font-weight-bold"></p>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="transaction_number">Sales Order ID</label>
            <p id="transaction_number" class="font-weight-bold"></p>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="courier_schedule">Schedule Date</label>
            <p id="courier_schedule" class="font-weight-bold"></p>
        </div>
    </div>
    <div class="col-sm-6 mb-4">
        <h2 class="c-form--title">Client Data</h2>
        <div class="form-group">
            <label class="c-form--label" for="customer_name">Client Name</label>
            <p id="customer_name" class="font-weight-bold"></p>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="phone_number">Phone Number</label>
            <p id="phone_number" class="font-weight-bold"></p>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="address">Address</label>
            <p id="address" class="font-weight-bold"></p>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="outlet">POS</label>
            <p id="outlet" class="font-weight-bold"></p>
        </div>
    </div>
</div>

<div class="c-table--outer mx-0 d-none d-md-block d-lg-block">
    <div class="table-responsive">
        <table id="table-item-courier-pickup-schedule" class="c-table table table-striped">
            <thead>
                <tr>
                    <th class="checkbox"></th>
                    <th class="th-item">Sales Order Id</th>
                    <th class="th-note">Customer</th>
                    <th class="th-item">Address</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="d-sm-block d-md-none">
    <h2 class="c-form--title">Sales Order</h2>
    <div id="table-item-courier-pickup-schedule-mobile">
    </div>
</div>

<hr class="my-4">
<div class="row">
    <div class="col-sm-6 text-left"></div>
    <div class="col-sm-6 text-right">
        <a href="{{ route('courier.pickup_schedules.index') }}" class="btn btn-primary">Submit</a>
    </div>
</div>
