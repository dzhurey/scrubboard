<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            body {
                font-family: 'open-sans';
                font-size: 12px;
                line-height: normal;
            }
            .page-break {
                page-break-after: always;
            }
            table, th, td {
                border-collapse: collapse;
                font-family: Calibri, 'Trebuchet MS', sans-serif;
            }
            .pdf-table-list-item th, .pdf-table-list-item td{
                border-bottom: 1px solid #ddd;
                padding: 10px;
            }
            .pdf-table-list-item tr:last-child {
                border-bottom: none;
            }
            th, td {
                padding: 5px;
                text-align: left;
                vertical-align: top;  
            }
            .text-right {
                text-align: right;
            }
            .background {
                font-family: 'open-sans';
                text-align: center;
                opacity: 0.3;
                z-index: 0;
                font-size: 54px;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <table width="100%">
            <tr>
                <td colspan="3">
                    <img class="logo-full" src="{{ public_path().'/assets/images/logo-bebewash.png' }}" height="50">
                </td>
                <td colspan="3">
                    <div class="background">UNPAID</div>
                </td>
            </tr>
            <tr>
                <td colspan="6"></td>
            </tr>
            <tr>
                <td colspan="5">No. Order</td>
                <td>Order Type</td>
            </tr>
            <tr>
                <td colspan="5"><b>{{ $sales_order->transaction_number }}</b></td>
                <td>
                    @if($sales_order->is_pre_order)
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
                <td colspan="1"><b>{{ $sales_order->customer->name }}</b></td>
                <td>
                    <b>{{ $sales_order->address['description'] }}</b>,
                    <b>{{ $sales_order->address['district'] }}</b>,<br/>
                    <b>{{ $sales_order->address['city'] }}</b>,
                    <b>{{ $sales_order->address['country'] }}</b>,<br/>
                    <b>{{ $sales_order->address['zip_code'] }}</b>,
                </td>
                <td colspan="4"><b>{{ $sales_order->transaction_date }}</b></td>
            </tr>
            <tr>
                <td colspan="6"></td>
            </tr>
            <tr>
                <td>
                    <strong>No HP/WA</strong>
                    <div>{{ $sales_order->customer->phone_number }}</div>
                </td>
                <td>
                    <strong>Pickup Date</strong>
                    <div>{{ $sales_order->pickup_date }}</div>
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
                @foreach ($sales_order->transaction_lines as $value)
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
            <!-- <tr>
                <td colspan="4">Cash</td>
                <td class="text-right">Bebemoney</td>
                <td class="text-right">0</td>
            </tr> -->
            <tr>
                <td colspan="4"></td>
                <td class="text-right">Total</td>
                <td class="text-right">{{ round($sales_order->original_amount) }}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td class="text-right">Booking Fee</td>
                <td class="text-right">{{ round($sales_order->dp_amount) }}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td class="text-right">Delivery Fee</td>
                <td class="text-right">{{ round($sales_order->freight) }}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td class="text-right">Discount</td>
                <td class="text-right">{{ round($sales_order->discount_amount) }}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td class="text-right" style="font-size: 16px; font-weight: bold">Grand Total</td>
                <td class="text-right" style="font-size: 16px; font-weight: bold">{{ round($sales_order->total_amount - $sales_order->dp_amount) }}</td>
            </tr>
            <tr>
                <td style="padding-top: 60px; text-align: center;" colspan="6">Thank you for trusting our services</td>
            </tr>
        </table>
        
        {{-- <div class="page-break"></div>
        <h1>Page 2</h1> --}}
    </body>
</html>
