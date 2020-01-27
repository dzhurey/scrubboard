<div id="logo-print" class="d-none mb-5">
    <img class="logo-full" src="{{ asset('assets/images/logo-bebewash.png') }}" height="70">
</div>

<div class="row mb-4">
    <div class="col-sm-4">
        <div class="form-group">
            <label id="invoice-number" class="c-form--label" for="order_id">Sales Order</label>
            <input class="form-control cursor-pointer" id="order_id" name="order_id" required readonly placeholder="Sales Order ID" /><button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#modal-sales-order-on-invoice">Add Sales Order</button>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
    </div>
    <div class="col-sm-4"></div>
    <div class="col-sm-4 text-right">
        <button id="btn-print" class="btn btn-primary btn-sm" type="button">
            <i class="fa fa-print"></i>&nbsp;Print Invoice
        </button>
    </div>
</div>

<hr class="my-4 mb-5">

<h2 class="c-form--title">Invoice Data</h2>
<div id="inv-data" class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="order_type">Order type</label>
            <input class="form-control cursor-pointer" id="order_type" name="order_type" required readonly placeholder="Order Type" />
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="customer_id">Client</label>
            <input class="form-control cursor-pointer" id="customer_id" name="customer_id" required readonly placeholder="Client Name" />
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div id="pos-outlet" class="form-group">
            <label class="c-form--label" for="agent_outlet">POS</label>
            <input class="form-control cursor-pointer" id="agent_outlet" name="agent_outlet" required readonly placeholder="POS Name" />
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div id="pickup-outlet" class="form-group">
            <div class="form-check form-check-inline">
                <input class="form-check-input form-check-box is-reverse" id="is_own_address" type="checkbox" name="is_own_address" checked readonly>
                <label class="form-check-label" for="is_own_address">Deliver to outlet</label>
            </div>
        </div>
    </div>
    <div class="col-sm-2"></div>
    <div class="col-sm-6">
        <div class="row">
            <div id="status--order" class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="status_order">Status order</label>
                    <input class="form-control" id="status_order" name="status_order" readonly>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="transaction_date">Document date</label>
                    <input class="form-control datetimepicker" id="transaction_date" name="transaction_date" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div id="pickup-date" class="col-sm-6 d-none">
                <div class="form-group">
                    <label class="c-form--label" for="pickup_date">Pick Up date</label>
                    <input class="form-control datetimepicker" id="pickup_date" name="pickup_date" required readonly>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div id="delivery--date" class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="delivery_date">Delivery date</label>
                    <input class="form-control datetimepicker" id="delivery_date" name="delivery_date" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div id="due--date" class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="due_date">Due date</label>
                    <input class="form-control datetimepicker" id="due_date" name="due_date" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="c-table--outer mx-0">
    <div class="table-responsive">
        <table id="table-so-item" class="c-table table table-striped">
            <thead>
                <tr>
                    <th class="th-item">Item</th>
                    <th class="th-price">BOR<span style="color: red">&nbsp;*</span></th>
                    <th class="th-note">Brand</th>
                    <th class="th-price">Color</th>
                    <th class="th-total">Code/Promo</th>
                    <th class="th-qty text-right">Qty</th>
                    <th class="th-price text-right">Unit Price</th>
                    <th class="th-dcs text-right">Disc (%)</th>
                    <th class="th-total text-right">Total</th>
                    <th class="th-note">Notes</th>
                    <th class="th-action"></th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- <div id="foot-note" class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="note">Note</label>
            <textarea class="form-control" id="note" rows="6"></textarea>
        </div>
    </div>
    <div class="col-sm-3"></div>
    <div class="col-sm-5">
        <div class="form-group">
            <label class="c-form--label" for="original_amount">Total Before Discount</label>
            <div class="input-group flex-nowrap">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input class="form-control" id="original_amount" value="0" readonly>
            </div>
        </div>
        <div class="row">
            <div id="discount-percent" class="col-sm-3">
                <div class="form-group">
                    <label class="c-form--label" for="discount">Discount %</label>
                    <input class="form-control" id="discount" value="0" readonly>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="form-group">
                    <label class="c-form--label" for="discount_amount">Amount Discount</label>
                    <input class="form-control" id="discount_amount" value="0" readonly>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="freight">Freight</label>
            <div class="input-group flex-nowrap">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input class="form-control" id="freight" value="0">
            </div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="total_amount">Total</label>
            <div class="input-group flex-nowrap">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input class="form-control" id="total_amount" value="0" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="total_amount">Total DP</label>
            <div class="input-group flex-nowrap">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input class="form-control" id="dp_amount" value="0">
            </div>
        </div>
    </div>
</div> -->

<div id="total-count" class="d-none mb-5">
    <div class="row">
        <div class="col-sm-6">
            <label class="c-form--label">Total Before Discount</label>
        </div>
        <div class="col-sm-6">
            <input class="form-control" id="original_amount_print" value="0" readonly>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="c-form--label">Amount Discount</label>
        </div>
        <div class="col-sm-6">
            <input class="form-control" id="discount_amount_print" value="0" readonly>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="c-form--label">Freight</label>
        </div>
        <div class="col-sm-6">
            <input class="form-control" id="freight_print" value="0" readonly>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="c-form--label">Total</label>
        </div>
        <div class="col-sm-6">
            <input class="form-control" id="total_amount_print" value="0" readonly>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="c-form--label">Total DP</label>
        </div>
        <div class="col-sm-6">
            <input class="form-control" id="dp_amount_print" value="0" readonly>
        </div>
    </div>
</div>

<!-- for print -->
<style>
    #invoice-print {
        font-family: 'open-sans';
        font-size: 12px;
        line-height: normal;
    }
    #invoice-print .page-break {
        page-break-after: always;
    }
    #invoice-print table, th, td {
        border-collapse: collapse;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }
    #invoice-print .pdf-table-list-item th,
    #invoice-print .pdf-table-list-item td{
        border-bottom: 1px solid #ddd;
        padding: 10px;
    }
    #invoice-print .pdf-table-list-item tr:last-child {
        border-bottom: none;
    }
    #invoice-print th, td {
        padding: 5px;
        text-align: left;
        vertical-align: top;  
    }
    #invoice-print .text-right {
        text-align: right;
    }
</style>
<div id="invoice-print">
    <table width="100%">
        <tr>
            <td colspan="6">
                <img class="logo-full" src="{{ public_path().'/assets/images/logo-bebewash.png' }}" height="70">
            </td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="5">No. Ivoice</td>
            <td>Order Type</td>
        </tr>
        <tr>
            <td colspan="5"><b>{{ $sales_invoice->transaction_number }}</b></td>
            <td>
                @if($sales_invoice->is_pre_order)
                    <b>Pre Order</b>
                @else
                    <b>General</b>
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="1">Client Name</td>
            <td>Address</td>
            <td colspan="4">Document Date</td>
        </tr>
        <tr>
            <td colspan="1"><b>{{ $sales_invoice->customer->name }}</b></td>
            <td>
                <b>{{ $sales_invoice->address['description'] }}</b>,
                <b>{{ $sales_invoice->address['district'] }}</b>,<br/>
                <b>{{ $sales_invoice->address['city'] }}</b>,
                <b>{{ $sales_invoice->address['country'] }}</b>,<br/>
                <b>{{ $sales_invoice->address['zip_code'] }}</b>,
            </td>
            <td colspan="4"><b>{{ $sales_invoice->transaction_date }}</b></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="5">No HP/WA</td>
            <td>{{ $sales_invoice->customer->phone_number }}</td>
        </tr>
        <tr>
            <td colspan="5"><b>Pickup Date</b></td>
            <td><b>{{ $sales_invoice->pickup_date }}</b></td>
        </tr>
    </table>
    <table class="pdf-table-list-item" style="margin-top: 50px;" width="100%">
        <thead>
            <tr>
                <th><b>Product</b></th>
                <th class="text-right"><b>Code/Promo</b></th>
                <th class="text-right"><b>Qty</b></th>
                <th class="text-right"><b>Unit Price</b></th>
                <th class="text-right"><b>Disc</b></th>
                <th class="text-right"><b>Total</b></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales_invoice->transaction_lines as $value)
            <tr>
                <td>{{ $value->item->description }}</td>
                <td class="text-right">{{ !empty($value->promo) ? $value->promo->code : '' }}</td>
                <td class="text-right">{{ $value->quantity }}</td>
                <td class="text-right">{{ $value->unit_price }}</td>
                <td class="text-right">{{ $value->discount }}</td>
                <td class="text-right">{{ $value->amount }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <table width="100%" style="margin-top: 20px;">
        <tr>
            <td colspan="4">Payment Method</td>
            <td class="text-right">Delivery Fee</td>
            <td class="text-right">{{ $sales_invoice->freight }}</td>
        </tr>
        <tr>
            <td colspan="4">Cash</td>
            <td class="text-right">Bebemoney</td>
            <td class="text-right">0</td>
        </tr>
        <tr>
            <td colspan="4" ></td>
            <td class="text-right">Booking Fee</td>
            <td class="text-right">0</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td class="text-right">Grand Total</td>
            <td class="text-right">{{ $sales_invoice->total_amount }}</td>
        </tr>
    </table>
    
    {{-- <div class="page-break"></div>
    <h1>Page 2</h1> --}}
</div>

<div id="footer-form">
    <hr class="my-4">
    <div class="row">
        <div class="col-sm-6 text-left">
            <button id="button-delete" class="btn btn-danger" type="button">Delete</button>
        </div>
        <div class="col-sm-6 text-right">
            <button class="btn btn-light mr-2" type="button">Cancel</button>
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>
    </div>
</div>