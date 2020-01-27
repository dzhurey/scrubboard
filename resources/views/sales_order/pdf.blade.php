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
                font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
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
            }
            .text-right {
                text-align: right;
            }
        </style>
    </head>
    <body>
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
                    <b>{{ $sales_order->address->description }}</b>,
                    <b>{{ $sales_order->address->district }}</b>,<br/>
                    <b>{{ $sales_order->address->city }}</b>,
                    <b>{{ $sales_order->address->country }}</b>,<br/>
                    <b>{{ $sales_order->address->zip_code }}</b>,
                </td>
                <td colspan="4"><b>{{ $sales_order->transaction_date }}</b></td>
            </tr>
            <tr>
                <td colspan="6"></td>
            </tr>
            <tr>
                <td colspan="5">No HP/WA</td>
                <td>{{ $sales_order->customer->phone_number }}</td>
            </tr>
            <tr>
                <td colspan="5"><b>Pickup Date</b></td>
                <td><b>{{ $sales_order->pickup_date }}</b></td>
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
                <tr>
                    <td>{{ $value->item->description }}</td>
                    <td class="text-right">{{ $value->promo->code }}</td>
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
                <td class="text-right">{{ $sales_order->freight }}</td>
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
                <td class="text-right">{{ $sales_order->total_amount }}</td>
            </tr>
        </table>
        
        {{-- <div class="page-break"></div>
        <h1>Page 2</h1> --}}
    </body>
</html>
