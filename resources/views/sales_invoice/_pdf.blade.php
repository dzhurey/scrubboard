<style>
    #invoice-print {
        font-family: 'open-sans';
        font-size: 10px;
        line-height: normal;
        width: 138mm;
    }
    @page {
        margin: 10mm 5mm;
    }
    #invoice-print .page-break {
        page-break-after: always;
    }
    #invoice-print table,
    #invoice-print th,
    #invoice-print td {
        border-collapse: collapse;
        font-family: Calibri, 'Trebuchet MS', sans-serif;
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
    #invoice-print .background {
        font-family: 'open-sans';
        text-align: center;
        opacity: 0.3;
        z-index: 0;
        font-size: 42px;
        font-weight: bold;
    }
</style>
<table width="100%">
    <tr>
        <td colspan="3">
            <img class="logo-full" src="{{ asset('/assets/images/logo-bebewash.png') }}" height="50">
        </td>
        <td colspan="3">
            @if (round($sales_invoice->balance_due) == 0)
                <div class="background">PAID</div>
            @else
                <div class="background">UNPAID</div>
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td colspan="5">No. Invoice</td>
        <td>Order Type</td>
    </tr>
    <tr>
        <td colspan="5" style="font-size: 16px"><b>{{ $sales_invoice->transaction_number }}</b></td>
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
            <b>{{ $sales_invoice->address['description'] }}</b>,<br/>
            <b>{{ $sales_invoice->address['district'] }}</b>,
            <b>{{ $sales_invoice->address['city'] }}</b>,<br/>
            <b>{{ $sales_invoice->address['country'] }}</b>,
            <b>{{ $sales_invoice->address['zip_code'] }}</b>,
        </td>
        <td colspan="4"><b>{{ $sales_invoice->transaction_date }}</b></td>
    </tr>
    <tr>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td>
            <strong>No HP/WA</strong>
            <div>{{ $sales_invoice->customer->phone_number }}</div>
        </td>
        <td>
            <strong>Pickup Date</strong>
            <div>{{ $sales_invoice->pickup_date }}</div>
        </td>
        <td colspan="4"></td>
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
            @if($value->quantity > 0)
            <tr>
                <td>{{ $value->item->description }}</td>
                <td class="text-right">{{ !empty($value->promo) ? $value->promo->code : '' }}</td>
                <td class="text-right">{{ round($value->quantity) }}</td>
                <td class="text-right">{{ round($value->unit_price) }}</td>
                <td class="text-right">{{ round($value->discount) }}</td>
                <td class="text-right">{{ round($value->amount) }}</td>
            </tr>
            @endif
        @endforeach
    </tbody>
</table>
<table width="100%" style="margin-top: 20px;">
    <tr>
        <td colspan="4"></td>
        <td class="text-right">Total</td>
        <td class="text-right">{{ round($sales_invoice->original_amount) }}</td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td class="text-right">Booking Fee</td>
        <td class="text-right">{{ round($sales_invoice->dp_amount) }}</td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td class="text-right">Delivery Fee</td>
        <td class="text-right">{{ round($sales_invoice->freight) }}</td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td class="text-right">Discount</td>
        <td class="text-right">{{ round($sales_invoice->discount_amount) }}</td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td class="text-right" style="font-size: 16px; font-weight: bold">Grand Total</td>
        <td class="text-right" style="font-size: 16px; font-weight: bold">{{ round($sales_invoice->total_amount - $sales_invoice->dp_amount) }}</td>
    </tr>
    <tr>
        <td style="padding-top: 60px; text-align: center;" colspan="6">Thank you for trusting our services</td>
    </tr>
</table>

{{-- <div class="page-break"></div>
<h1>Page 2</h1> --}}