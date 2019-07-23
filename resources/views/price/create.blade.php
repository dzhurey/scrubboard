@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Membuat Harga</div>

    <div class="card-body">
        {{ Form::open(['url' => route('prices.store'), 'method' => 'POST', 'id' => 'formPrice']) }}
            @include('price._form_field')
        {{ Form::close() }}
        <button id="buttonSubmit" class="btn btn-primary">Buat</button>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var $form = $('#formPrice')
            var $submitButton = $('#buttonSubmit')

            $submitButton.on('click', function() {
                var priceLines = []
                $('#dynamicForm .entry').each(function() {
                    data = {
                        item_id: $(this).find('select option:selected').val(),
                        amount: $(this).find('input[name="price_lines[amount][]"]').val()
                    }
                    priceLines.push(data)
                })

                var data = {
                    name: $form.find('input[name="name"]').val(),
                    price_lines: priceLines
                }

                $.ajax({
                    url: $form.attr('action'),
                    type: 'post',
                    data: JSON.stringify(data),
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": $form.find('input[name="_token"]').val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        alert('data berhasil disimpan');
                    }
                });
            })
        })
    </script>
@stop
