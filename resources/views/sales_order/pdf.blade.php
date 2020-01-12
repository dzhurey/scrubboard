<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            .page-break {
                page-break-after: always;
            }
        </style>
    </head>
    <body>
        <h1>Bebewash</h1>
        <h5>ID</h5>{{ $sales_order->transaction_number }}
        <h5>Client Name</h5>{{ $sales_order->customer->name }}
        <h5>POS</h5>{{ $sales_order->agent->name }}
        <h5>Order Status</h5>{{ $sales_order->transaction_status }}
        <h5>Pickup Status</h5>{{ $sales_order->pickup_status }}
        <h5>Document Date</h5>{{ $sales_order->transaction_date }}
        <h5>Pickup Date</h5>{{ $sales_order->pickup_date }}
        <h5>Total</h5>{{ $sales_order->total_amount }}
        <h5>Items</h5>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Bor</th>
                    <th>Brand</th>
                    <th>Color</th>
                    <th>Quantity</th>
                    <th>Discount</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales_order->transaction_lines as $value)
                    <tr>
                        <td>{{ $value->item->description }}</td>
                        <td>{{ $value->bor }}</td>
                        <td>{{ $value->brand->name }}</td>
                        <td>{{ $value->color }}</td>
                        <td>{{ $value->quantity }}</td>
                        <td>{{ $value->discount }}</td>
                        <td>{{ $value->unit_price }}</td>
                        <td>{{ $value->amount }}</td>
                        <td>{{ $value->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- <div class="page-break"></div>
        <h1>Page 2</h1> --}}
    </body>
</html>
