{{ csrf_field() }}
<div class="form-group">
    <label>Nama</label>
    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ !empty($price->id) ? $price->name : old('name') }}">
    @if ($errors->has('name'))
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
    @endif
</div>
<h5>List Harga</h5>
<div id="dynamicForm" class="controls">
    <div class="entry row">
        <div class="col-5">
            {{ Form::select('price_lines[item_id][]', $items, null, ['class' => 'form-control']) }}
        </div>
        <div class="col-5">
            <input class="form-control" type="text" name="price_lines[amount][]">
        </div>
        <div class="col-2">
            <button class="btn btn-success btn-add" type="button">
                Add
            </button>
        </div>
    </div>
</div>