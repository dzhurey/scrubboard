@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Mengubah Harga</div>

    <div class="card-body">
        {{ Form::open(['url' => route('prices.update', ['price' => $price->id]), 'method' => 'put', 'id' => 'formPrice']) }}
            @include('price._form_field')
        {{ Form::close() }}
        <button id="buttonSubmit" class="btn btn-primary">Update</button>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var $form = $('#formPrice')
            var $submitButton = $('#buttonSubmit')

            $.ajax({
                url: window.location.href.replace('/edit', ''),
                type: 'get',
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": $form.find('input[name="_token"]').val()
                },
                dataType: 'json',
                success: function (data) {
                    var priceLines = data.price.price_lines
                }
            });

            $submitButton.on('click', function() {
                var data = {
                    name: $form.find('input[name="name"]').val(),
                    price_lines: [
                        {
                            amount: "4000",
                            id: 1,
                            item_id: 2,
                            price_id: 3
                        }
                    ]
                }

                $.ajax({
                    url: $form.attr('action'),
                    type: 'put',
                    data: JSON.stringify(data),
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": $form.find('input[name="_token"]').val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        alert('sukses');
                    }
                });
            })
        })
    </script>
@stop